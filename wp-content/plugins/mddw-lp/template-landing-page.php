<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LandingPage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <style>
    section {
      background: rgb(74, 48, 192);
      background: -moz-linear-gradient(215deg, rgba(74, 48, 192, 1) 0%, rgba(192, 48, 120, 1) 100%);
      background: -webkit-linear-gradient(215deg, rgba(74, 48, 192, 1) 0%, rgba(192, 48, 120, 1) 100%);
      background: linear-gradient(215deg, rgba(74, 48, 192, 1) 0%, rgba(192, 48, 120, 1) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#4a30c0", endColorstr="#c03078", GradientType=1);
    }

    .container {
      height: 100vh;
    }

    .photo {
      border-radius: 100%;
      box-shadow: 1px 1px 6px 3px;

    }
  </style>
  <?php print_r(the_post()) ?>
  <section>
    <div class="container">
      <div class="col-md-12 col-12 h-100">
        <div class="d-flex justify-content-center align-items-center h-25 mb-5">
          <img src="https://picsum.photos/200" alt="" srcset="" class="mt-5 photo">
        </div>
        <div class="d-flex flex-row justify-content-center align-items-center gap-3">
          <p>t</p>
          <p>t</p>
          <p>t</p>
          <p>t</p>
        </div>
        <div class="d-flex justify-content-center mt-5">

          <div class="d-flex flex-column justify-content-center align-items-center w-100">
            <?php
            // Obtém os valores das metaboxes
            $meta_values = get_post_meta(get_the_ID(), '_meu_plugin_meta_data', true);

            // Verifica se existem valores e se é um array
            if (!empty($meta_values) && is_array($meta_values)) :
              foreach ($meta_values as $meta_value) :
            ?>
                <a href="<?= $meta_value['url'] ?>" class="w-100"><button type="button" style="box-shadow: 1px 1px 11px -3px black" class="rounded-5 btn btn-primary m-2 w-100 fs-4 fw-bold"><?= $meta_value['texto'] ?></button></a>
            <?php endforeach;
            endif; ?>
          </div>

        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>