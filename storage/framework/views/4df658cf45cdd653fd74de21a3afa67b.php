


<?php $__env->startSection('title', 'Register | GownEase'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="content-card p-4 p-md-5">

            <h2 class="brand mb-2">Create an account</h2>

            <p class="text-secondary">
                Join GownEase to rent your favorite gowns.
            </p>

            <form action="<?php echo e(route('register.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Full name</label>
                    <input type="text"
                           name="name"
                           value="<?php echo e(old('name')); ?>"
                           class="form-control"
                           maxlength="100"
                           required>

                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email"
                           name="email"
                           value="<?php echo e(old('email')); ?>"
                           class="form-control"
                           required>

                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           minlength="8"
                           required>

                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           minlength="8"
                           required>
                </div>

                <!-- Google reCAPTCHA -->
                <div class="mb-3">
                    <div class="g-recaptcha"
                         data-sitekey="<?php echo e(config('services.recaptcha.site_key')); ?>">
                    </div>

                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger d-block"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <?php $__errorArgs = ['recaptcha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger d-block"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Create Account
                </button>
            </form>

            <p class="mt-3 mb-0 text-center">
                Already registered?
                <a href="<?php echo e(route('login')); ?>">Login here</a>
            </p>

        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\SIA_FINALS\Gownease\resources\views/auth/register.blade.php ENDPATH**/ ?>