<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Page</title>
</head>
<body>
    <script>
        // Get the URL parameter containing the page title
        const urlParams = new URLSearchParams(window.location.search);
        const title = urlParams.get('title');

        // Display the extracted title
        console.log("Page Title:", title);
        // You can use the title variable as needed
    </script>
</body>
</html>
