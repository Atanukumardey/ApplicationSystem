<?php
function loginSuccess()
{
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
        })
    </script>
<?php
}
?>

<?php function popupMessage($messageType, $messageBody, $buttonText)
{
?>
    <script>
        Swal.fire({
            icon: <?= json_encode($messageType) ?>,
            title: <?= json_encode($messageBody) ?>,
            confirmButtonText: <?= json_encode($buttonText) ?>
        })
    </script>
<?php
}
?>

<?php
function createFloatNavbar($NavbarData)
{
?>
    <ul id="menubar" class=" mfb-component--tr mfb-slidein-spring" data-mfb-toggle="hover" style="margin-top: 19vh;">
        <li class="mfb-component__wrap">
            <a href="#" class="mfb-component__button--main">
                <i class="mfb-component__main-icon--resting fa fa-bars"></i>
                <i class="mfb-component__main-icon--active fa fa-times"></i>
            </a>
            <ul class="mfb-component__list">
                <?php
                foreach ($NavbarData as $navitem) {
                ?>
                    <li>
                        <a href=<?= $navitem['link'] ?> data-mfb-label=<?= json_encode($navitem['text']) ?> class="mfb-component__button--child">
                            <i class="mfb-component__child-icon <?= $navitem['icon'] ?>"></i>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </li>
    </ul>
<?php } ?>