<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Blog</title>
  <link rel="stylesheet" href="/style.css">
</head>

<body>
  <header>
    <h1>Welcome</h1>
  </header>
  <nav>
    <a href="/">Home</a>
  </nav>
  <main>
    <?= $content ?>
  </main>
  <footer>
    copyright &copy; <?= date('Y') ?> My Website. All rights reserved.
  </footer>
</body>

</html>
