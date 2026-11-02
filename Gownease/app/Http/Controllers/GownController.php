<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Gown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GownController extends Controller
{
    /**
     * Customer shop with search, category, color, size,
     * price filters, and sorting.
     */
    public function shop(Request $request)
    {
        $allowedSorts = ['price_low', 'price_high', 'name'];

        $sort = $request->input('sort');

        $gowns = Gown::query()
            ->where('status', 'available')

            // Search products.
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('color', 'like', "%{$search}%")
                        ->orWhere('size', 'like', "%{$search}%");
                });
            })

            // Show ONLY the selected category.
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where(
                    'category',
                    trim($request->input('category'))
                );
            })

            // Filter by color.
            ->when($request->filled('color'), function ($query) use ($request) {
                $query->where('color', $request->input('color'));
            })

            // Filter by size.
            ->when($request->filled('size'), function ($query) use ($request) {
                $query->where('size', $request->input('size'));
            })

            // Minimum rental price.
            ->when(
                $request->filled('min_price')
                    && is_numeric($request->input('min_price'))
                    && (float) $request->input('min_price') >= 0,
                function ($query) use ($request) {
                    $query->where(
                        'rental_price',
                        '>=',
                        (float) $request->input('min_price')
                    );
                }
            )

            // Maximum rental price.
            ->when(
                $request->filled('max_price')
                    && is_numeric($request->input('max_price'))
                    && (float) $request->input('max_price') >= 0,
                function ($query) use ($request) {
                    $query->where(
                        'rental_price',
                        '<=',
                        (float) $request->input('max_price')
                    );
                }
            )

            // Sorting.
            ->when($sort === 'price_low', function ($query) {
                $query->orderBy('rental_price', 'asc');
            })
            ->when($sort === 'price_high', function ($query) {
                $query->orderBy('rental_price', 'desc');
            })
            ->when($sort === 'name', function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->when(
                !in_array($sort, $allowedSorts, true),
                function ($query) {
                    $query->latest();
                }
            )

            ->paginate(12)
            ->withQueryString();

        // Dropdown options.
        $categories = Gown::where('status', 'available')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $colors = Gown::where('status', 'available')
            ->whereNotNull('color')
            ->where('color', '!=', '')
            ->distinct()
            ->orderBy('color')
            ->pluck('color');

        $sizes = Gown::where('status', 'available')
            ->whereNotNull('size')
            ->where('size', '!=', '')
            ->distinct()
            ->orderBy('size')
            ->pluck('size');

        return view('shops.index', compact(
            'gowns',
            'categories',
            'colors',
            'sizes'
        ));
    }

    /**
     * Display a product.
     */
    public function showProduct(Gown $gown)
    {
        abort_unless($gown->status === 'available', 404);

        return view('shops.show', compact('gown'));
    }

    /**
     * Admin product list.
     */
    public function index()
    {
        $gowns = Gown::latest()->paginate(10);

        return view('admin.gowns.index', compact('gowns'));
    }

    /**
     * Admin add-product form.
     */
    public function create()
    {
        return view('admin.gowns.create');
    }

    /**
     * Save a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'size' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'rental_price' => 'required|numeric|min:0',
            'deposit_price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable,maintenance',
        ]);

        $validated['image'] = $request->file('image')
            ->store('gowns', 'public');

        $validated['deposit_price'] = $validated['deposit_price'] ?? 0;

        Gown::create($validated);

        return redirect()
            ->route('admin.gowns.index')
            ->with('success', 'Product added successfully!');
    }

    /**
     * Admin edit-product form.
     */
    public function edit(Gown $gown)
    {
        return view('admin.gowns.edit', compact('gown'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Gown $gown)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'size' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'rental_price' => 'required|numeric|min:0',
            'deposit_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable,maintenance',
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('gowns', 'public');

            if ($gown->image) {
                Storage::disk('public')->delete($gown->image);
            }

            $validated['image'] = $newImage;
        }

        $validated['deposit_price'] = $validated['deposit_price'] ?? 0;

        $gown->update($validated);

        return redirect()
            ->route('admin.gowns.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a product without rental records.
     */
    public function destroy(Gown $gown)
    {
        if ($gown->bookings()->exists()) {
            return back()->with(
                'error',
                'This product has rental records. Mark it unavailable instead.'
            );
        }

        if ($gown->image) {
            Storage::disk('public')->delete($gown->image);
        }

        $gown->delete();

        return redirect()
            ->route('admin.gowns.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Display shopping cart.
     */
    public function cart()
    {
        $cart = session()->get('gown_cart', []);

        $items = collect($cart)->map(function ($quantity, $gownId) {
            $gown = Gown::where('status', 'available')
                ->find($gownId);

            if (!$gown) {
                return null;
            }

            $gown->cart_quantity = (int) $quantity;
            $gown->cart_subtotal = (float) $gown->rental_price
                * (int) $quantity;

            return $gown;
        })->filter()->values();

        $total = $items->sum('cart_subtotal');

        return view('admin.gowns.cart.index', compact('items', 'total'));
    }

    /**
     * Add a product to the shopping cart.
     */
    public function addToCart(Request $request, Gown $gown)
    {
        abort_unless($gown->status === 'available', 404);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = session()->get('gown_cart', []);

        $currentQuantity = (int) ($cart[$gown->id] ?? 0);
        $newQuantity = $currentQuantity + (int) $validated['quantity'];

        if ($newQuantity > 10) {
            return back()->with(
                'error',
                'You can add a maximum of 10 of this product.'
            );
        }

        $cart[$gown->id] = $newQuantity;

        session()->put('gown_cart', $cart);

        return redirect()
            ->route('shop.show', $gown)
            ->with('success', 'Product added to your cart!');
    }

    /**
     * Update cart quantity.
     */
    public function updateCart(Request $request, Gown $gown)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        abort_unless($gown->status === 'available', 404);

        $cart = session()->get('gown_cart', []);

        if (!array_key_exists($gown->id, $cart)) {
            return redirect()->route('cart.index');
        }

        $cart[$gown->id] = (int) $validated['quantity'];

        session()->put('gown_cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart quantity updated!');
    }

    /**
     * Remove a product from the cart.
     */
    public function removeFromCart(Gown $gown)
    {
        $cart = session()->get('gown_cart', []);

        unset($cart[$gown->id]);

        session()->put('gown_cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product removed from your cart.');
    }

    /**
     * Display checkout and payment methods.
     */
    public function checkout()
    {
        $cart = session()->get('gown_cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $items = collect($cart)->map(function ($quantity, $gownId) {
            $gown = Gown::where('status', 'available')
                ->find($gownId);

            if (!$gown) {
                return null;
            }

            $gown->cart_quantity = (int) $quantity;
            $gown->cart_subtotal = (float) $gown->rental_price
                * (int) $quantity;

            return $gown;
        })->filter()->values();

        if ($items->isEmpty()) {
            session()->forget('gown_cart');

            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart items are no longer available.');
        }

        $total = $items->sum('cart_subtotal');

        return view('admin.gowns.cart.checkout', compact('items', 'total'));
    }

    

/**
 * Process checkout and create rental bookings.
 */
public function processCheckout(Request $request)
{
    $validated = $request->validate([
        'rental_start_date' => 'required|date|after_or_equal:today',
        'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
        'payment_method' => 'required|in:gcash,pay_at_store',
    ]);

    $cart = session()->get('gown_cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Your shopping cart is empty.');
    }

    $gownIds = array_map('intval', array_keys($cart));

    $gowns = Gown::whereIn('id', $gownIds)
        ->where('status', 'available')
        ->get()
        ->keyBy('id');

    if ($gowns->count() !== count(array_unique($gownIds))) {
        return redirect()->route('cart.index')
            ->with('error', 'Some products are unavailable. Please review your cart.');
    }

    $startDate = $validated['rental_start_date'];
    $endDate = $validated['rental_end_date'];
    $paymentMethod = $validated['payment_method'];

    try {
        DB::transaction(function () use (
            $cart,
            $gowns,
            $startDate,
            $endDate,
            $paymentMethod
        ) {
            foreach ($cart as $gownId => $quantity) {
                $gownId = (int) $gownId;
                $quantity = (int) $quantity;

                if ($quantity < 1 || $quantity > 10) {
                    throw new \RuntimeException('Invalid product quantity.');
                }

                $gown = $gowns->get($gownId);

                if (!$gown) {
                    throw new \RuntimeException('A selected product is unavailable.');
                }

                // Check whether this gown is already booked for these dates.
                $conflict = DB::table('bookings')
                    ->where('gown_id', $gownId)
                    ->whereIn('status', ['pending', 'approved', 'active'])
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate)
                    ->exists();

                if ($conflict) {
                    throw new \RuntimeException(
                        $gown->name . ' is already booked for the selected dates.'
                    );
                }

                DB::table('bookings')->insert([
                    'user_id' => auth()->id(),
                    'gown_id' => $gownId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_price' => (float) $gown->rental_price * $quantity,
                    'status' => 'pending',
                    'notes' => 'Payment method: '
                        . ($paymentMethod === 'gcash' ? 'GCash' : 'Pay at Store')
                        . '; Quantity: ' . $quantity
                        . ($paymentMethod === 'gcash'
                            ? '; Payment pending verification.'
                            : '; Payment to be collected at store.'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    } catch (\Throwable $e) {
        report($e);

        $message = $e instanceof \RuntimeException
            ? $e->getMessage()
            : 'We could not save your booking. Your cart has been preserved. Please try again.';

        return redirect()->route('checkout.index')
            ->withInput()
            ->with('error', $message);
    }

    // Empty the cart only after the transaction succeeds.
    session()->forget('gown_cart');

    return redirect()->route('shop')
        ->with(
            'success',
            $paymentMethod === 'gcash'
                ? 'Your rental request was saved. GCash payment is still pending verification.'
                : 'Your rental request was saved. Please pay at the store. Your booking is pending approval.'
        );


}

}
