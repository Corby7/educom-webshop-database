<?php

/** Display the title for the error page. */
function showErrorTitle() {
    echo 'Page Not Found';
}

/** Display the header for the error page. */
function showErrorHeader() {
    echo 'Error 404';
}

/** Display the content for the error page. */
function showErrorContent() {
    echo '
        <h1>Page Not Found</h1>
        <p>The requested page could not be found. Please check the URL or return to the homepage.</p>';
}


?>