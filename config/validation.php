<?php
if (!defined('BASEPATH')) {
    define('BASEPATH', true);
}

function escape_output($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if (!defined('SWEETALERT_INCLUDED')) {
    echo '<script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>';
    define('SWEETALERT_INCLUDED', true);
}

function swal_error(string $title, string $text, string $button = 'OK', string $redirect = ''): void
{
    $title = escape_output($title);
    $text = escape_output($text);
    $button = escape_output($button);

    echo "
    <script>
        setTimeout(() => {
            Swal.fire({
                icon: 'error',
                title: '$title',
                text: '$text',
                confirmButtonText: '$button'
            })" . ($redirect ? ".then(() => { window.location.href = '$redirect'; })" : "") . ";
        }, 2000);
    </script>
    ";
}

function swal_success(string $title, string $text, string $button = 'OK', string $redirect = ''): void
{
    $title = escape_output($title);
    $text = escape_output($text);
    $button = escape_output($button);

    echo "
    <script>
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: '$title',
                text: '$text',
                confirmButtonText: '$button'
            })" . ($redirect ? ".then(() => { window.location.href = '$redirect'; })" : "") . ";
        }, 2000);
    </script>
    ";
}

function swal_question(string $title, string $text, string $confirmUrl, string $confirmButtonText = 'Ya', string $cancelButtonText = 'Tidak'): void
{
    $title = escape_output($title);
    $text = escape_output($text);
    $confirmUrl = escape_output($confirmUrl);
    $confirmButtonText = escape_output($confirmButtonText);
    $cancelButtonText = escape_output($cancelButtonText);

    echo "
    <script>
        setTimeout(() => {
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '$confirmButtonText',
                cancelButtonText: '$cancelButtonText'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '$confirmUrl';
                }
            });
        }, 2000);
    </script>
    ";
}

function swal_confirm(string $title, string $text, string $confirmUrl, string $confirmButtonText = 'Ya', string $cancelButtonText = 'Tidak'): void
{
    $title = escape_output($title);
    $text = escape_output($text);
    $confirmUrl = escape_output($confirmUrl);
    $confirmButtonText = escape_output($confirmButtonText);
    $cancelButtonText = escape_output($cancelButtonText);

    echo "
    <script>
        setTimeout(() => {
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '$confirmButtonText',
                cancelButtonText: '$cancelButtonText',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '$confirmUrl';
                }
            });
        }, 2000);
    </script>
    ";
}

function swal_info(string $title, string $text, string $button = 'OK', string $redirect = ''): void
{
    $title = escape_output($title);
    $text = escape_output($text);
    $button = escape_output($button);

    echo "
    <script>
        setTimeout(() => {
            Swal.fire({
                icon: 'info',
                title: '$title',
                text: '$text',
                confirmButtonText: '$button'
            })" . ($redirect ? ".then(() => { window.location.href = '$redirect'; })" : "") . ";
        }, 2000);
    </script>
    ";
}
