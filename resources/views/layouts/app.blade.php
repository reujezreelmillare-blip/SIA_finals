
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'GownEase')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- GownEase Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --ge-plum: #30263A;
            --ge-plum-light: #51415F;
            --ge-ivory: #F8F5F0;
            --ge-champagne: #B79A78;
            --ge-text: #302B32;
            --ge-muted: #777078;
            --ge-border: #E8E0D8;
            --ge-white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--ge-white);
            color: var(--ge-text);
            font-size: 14px;
            line-height: 1.7;
        }

        h1, h2, h3, h4, h5, h6, .brand {
            font-family: 'Playfair Display', serif;
            color: var(--ge-plum);
        }

        a {
            color: var(--ge-plum-light);
            transition: color .2s ease;
        }

        a:hover {
            color: var(--ge-champagne);
        }

        /* Navigation */
        .ge-navbar {
            width: 100%;
            background: var(--ge-plum);
            padding: 14px 0;
        }

        .ge-navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .ge-logo {
            color: var(--ge-white) !important;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            white-space: nowrap;
        }

        .ge-logo:hover {
            color: var(--ge-champagne) !important;
        }

        .ge-nav-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ge-user-name {
            color: var(--ge-white);
            font-size: 13px;
            white-space: nowrap;
        }

        .ge-cart-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 13px;
            color: var(--ge-plum) !important;
            background: var(--ge-white);
            border: 1px solid var(--ge-border);
            border-radius: 4px;
            text-decoration: none;
            white-space: nowrap;
        }

        .ge-cart-link:hover {
            background: var(--ge-ivory);
            color: var(--ge-plum) !important;
        }

        .ge-cart-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 21px;
            height: 21px;
            padding: 0 5px;
            border-radius: 50px;
            background: #A33B50;
            color: white;
            font-size: 11px;
            font-weight: 600;
        }

        .ge-logout-form {
            margin: 0;
        }

        .ge-logout-button {
            padding: 8px 13px;
            border: 1px solid rgba(255,255,255,.8);
            border-radius: 4px;
            color: white;
            background: transparent;
            white-space: nowrap;
        }

        .ge-logout-button:hover {
            background: white;
            color: var(--ge-plum);
        }

        .ge-auth-link {
            color: white;
            text-decoration: none;
        }

        .ge-auth-link:hover {
            color: var(--ge-champagne);
        }

        .brand {
            color: var(--ge-plum);
            font-weight: 700;
        }

        /* Cards */
        .content-card {
            background: var(--ge-white);
            border: 1px solid var(--ge-border);
            border-radius: 8px;
            box-shadow: 0 4px 18px rgba(48, 38, 58, .05);
        }

        /* Buttons */
        .btn {
            font-family: 'Poppins', sans-serif;
            transition: background-color .2s ease,
                        border-color .2s ease,
                        transform .2s ease;
        }

        .btn-primary,
        .btn-dark {
            background: var(--ge-plum);
            border-color: var(--ge-plum);
            color: var(--ge-white);
        }

        .btn-primary:hover,
        .btn-dark:hover {
            background: var(--ge-plum-light);
            border-color: var(--ge-plum-light);
            color: var(--ge-white);
        }

        .btn-success {
            background: #526B53;
            border-color: #526B53;
        }

        /* Forms */
        .form-control,
        .form-select {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            border: 1px solid var(--ge-border);
            border-radius: 3px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--ge-champagne);
            box-shadow: 0 0 0 .2rem rgba(183, 154, 120, .18);
        }

        label,
        .form-label {
            font-weight: 500;
        }

        /* Tables */
        .table {
            --bs-table-color: var(--ge-text);
            --bs-table-hover-bg: var(--ge-ivory);
        }

        .table thead th {
            font-weight: 600;
            white-space: nowrap;
        }

        .alert {
            border-radius: 5px;
        }

        /* Shop images */
        .shop-product-image {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            background: var(--ge-ivory);
        }

        .shop-product-name {
            font-family: 'Playfair Display', serif;
            color: var(--ge-plum);
            text-decoration: none;
        }

        .product-detail-image {
            max-width: 100%;
            object-fit: cover;
            background: var(--ge-ivory);
        }

        /* Authentication pages */
        .login-page,
        .register-page {
            background: var(--ge-ivory);
        }

        .login-card,
        .register-card {
            background: var(--ge-white);
            border: 1px solid var(--ge-border);
            box-shadow: 0 12px 35px rgba(48, 38, 58, .08);
        }

        /* Mobile navigation */
        @media (max-width: 576px) {
            .ge-navbar {
                padding: 12px 0;
            }

            .ge-navbar-inner {
                align-items: flex-start;
                gap: 12px;
            }

            .ge-logo {
                font-size: 23px;
                padding-top: 3px;
            }

            .ge-nav-actions {
                gap: 7px;
                max-width: 70%;
            }

            .ge-user-name {
                width: 100%;
                text-align: right;
                font-size: 12px;
            }

            .ge-cart-link,
            .ge-logout-button {
                padding: 7px 9px;
                font-size: 12px;
            }

            main.container {
                padding-top: 22px !important;
            }
        }
    </style>
</head>

<body>
    <nav class="ge-navbar">
        <div class="container ge-navbar-inner">

            <a class="ge-logo" href="{{ url('/') }}">
                GownEase
            </a>

            <div class="ge-nav-actions">
                @auth
                    @php
                        $currentUser = auth()->user();
                        $cartData = session('gown_cart', []);

                        $cartCount = collect($cartData)->sum(
                            fn ($quantity) => is_array($quantity)
                                ? (int) ($quantity['quantity'] ?? 1)
                                : (int) $quantity
                        );
                    @endphp

                    <span class="ge-user-name">
                        {{ $currentUser->name }}
                    </span>

                    @if (!$currentUser->isAdmin())
                        <a href="{{ route('cart.index') }}"
                           class="ge-cart-link"
                           aria-label="Shopping cart, {{ $cartCount }} items">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span>Cart</span>
                            <span class="ge-cart-count">{{ $cartCount }}</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="ge-logout-form">
                        @csrf

                        <button type="submit" class="ge-logout-button">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="ge-auth-link">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="btn btn-outline-light btn-sm">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>
</body>
</html>
