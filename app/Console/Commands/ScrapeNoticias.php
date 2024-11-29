<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models\Noticia;

class ScrapeNoticias extends Command
{
    protected $description = 'Scrape noticias from Los Andes, Diario Sin Fronteras, Diario Correo, and La República';

    public function __construct()
    {
        parent::__construct();
    }

    protected $signature = 'scrape:noticias
    {--exitosa-noticias : Scrapear noticias de Exitosa Noticias}
    {--la-republica : Scrapear noticias de La República}
    {--sin-fronteras : Scrapear noticias de Diario Sin Fronteras}
    {--correo : Scrapear noticias de Diario Correo}
    {--ojo : Scrapear noticias de Diario Ojo}
    {--latina : Scrapear noticias de Latina Noticias}';

    public function handle()
    {
        $client = new Client();

        // Revisar y ejecutar el scraping para cada opción de revista
        if ($this->option('exitosa-noticias')) {
            $this->info("Iniciando scraping de Exitosa Noticias...");
            $this->scrapeExitosaNoticias($client);
        }

        if ($this->option('la-republica')) {
            $this->info("Iniciando scraping de La República...");
            $this->scrapeLaRepublica($client);
        }

        if ($this->option('sin-fronteras')) {
            $this->info("Iniciando scraping de Diario Sin Fronteras...");
            $this->scrapeSinFronteras($client);
        }

        if ($this->option('correo')) {
            $this->info("Iniciando scraping de Diario Correo...");
            $this->scrapeCorreo($client);
        }

        if ($this->option('ojo')) {
            $this->info("Iniciando scraping de Diario Ojo...");
            $this->scrapeOjo($client);
        }

        if ($this->option('latina')) {
            $this->info("Iniciando scraping de Latina Noticias...");
            $this->scrapeLatina($client);
        }

        $this->info("Scraping completo para todas las revistas seleccionadas.");
    }

    private function saveNoticia($title, $link, $image, $author, $category, $date = null)
    {
        // Verificar si la noticia ya existe
        if (Noticia::where('enlace', $link)->exists()) {
            $this->info("La noticia '$title' ya existe en la base de datos. Saltando...");
            return;
        }

        // Guardar la noticia en la base de datos
        Noticia::create([
            'titulo' => $title,
            'enlace' => $link,
            'imagen' => $image,
            'autor' => $author,
            'category' => $category,
            'fecha' => $date ?? 'Fecha desconocida',
        ]);

        // Mostrar los datos en consola
        $this->info("Título: $title");
        $this->info("Enlace: $link");
        $this->info("Imagen: $image");
        $this->info("Autor: $author");
        $this->info("Categoría: $category");
        $this->info('----');
    }



    // Método para obtener el texto de un nodo
    private function getNodeText($node)
    {
        return $node->count() > 0 ? $node->text() : null;
    }

    // Método para obtener el enlace de un nodo
    private function getNodeLink($node)
    {
        return $node->count() > 0 ? $node->link()->getUri() : null;
    }
    // Método para scraping de Exitosa Noticias
  // Método para scraping de Exitosa Noticias
  public function scrapeExitosaNoticias($client)
  {
      $baseUrl = 'https://www.exitosanoticias.pe/';
      $crawler = $client->request('GET', $baseUrl);

      $crawler->filter('article.noti-box')->each(function ($node) use ($client, $baseUrl) {
          $title = $this->getNodeText($node->filter('h3.tit a'));
          $link = $this->getNodeLink($node->filter('h3.tit a'));
          $image = $node->filter('img.cst_img')->count() > 0 ? $node->filter('img.cst_img')->attr('src') : '';
          $author = 'Desconocido';
          $category = 'Exitosa Noticias';
          $date = 'Fecha desconocida';

          if ($title && $link) {
              $this->saveNoticia($title, $link, $image, $author, $category, $date);
          } else {
              $this->error("No se encontró el título o enlace de la noticia.");
          }
      });
  }



    // Método para scraping de La República
    public function scrapeLaRepublica($client)
    {
        $baseUrl = 'https://larepublica.pe/';
        $crawler = $client->request('GET', $baseUrl);

        $crawler->filter('.ItemSection_itemSection__image__NeDIN')->each(function ($node) use ($client, $baseUrl) {
            $title = $this->getNodeText($node->siblings()->filter('.ItemSection_itemSection__title__PleA9'));
            $link = $this->getNodeLink($node->siblings()->filter('.ItemSection_itemSection__title__PleA9')->filter('a.extend-link'));
            $image = $node->filter('img.comp_image')->count() > 0 ? $node->filter('img.comp_image')->attr('src') : '';
            $author = 'Desconocido'; // No encontrado
            $category = 'La República';

            if ($title && $link) {
                $this->saveNoticia($title, $link, $image, $author, $category);
            } else {
                $this->error("No se encontró el título o enlace de la noticia.");
            }
        });
    }
    // Método para scraping de Diario Sin Fronteras
    public function scrapeSinFronteras($client)
    {
        // URL base del sitio
        $baseUrl = 'https://diariosinfronteras.com.pe/';

        // Realizamos la solicitud GET a la URL
        $crawler = $client->request('GET', $baseUrl);

        // Iteramos sobre cada post en la página principal
        $crawler->filter('.post.ws-post-sec')->each(function ($node) use ($client, $baseUrl) {

            // Extraemos el título del artículo
            $title = $this->getNodeText($node->filter('.entry-title a'));

            // Extraemos el enlace del artículo
            $link = $this->getNodeLink($node->filter('.entry-title a'));

            // Inicializamos la variable de la imagen
            $image = '';

            // Verificamos si hay una imagen asociada al post
            if ($node->filter('.ws-thumbnail img')->count() > 0) {
                // Obtenemos el atributo 'src' de la imagen
                $image = $node->filter('.ws-thumbnail img')->attr('src');

                // Si la imagen es una URL relativa, la convertimos a absoluta
                if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                    $image = $baseUrl . $image; // Concatenamos la URL base
                }
            }

            // Imprimimos la URL de la imagen (esto es opcional, para depuración)
            echo "Imagen URL: " . $image . "\n";

            // Extraemos el autor del artículo o usamos un valor por defecto
            $author = $this->getNodeText($node->filter('.post-author-bd a')) ?: 'Desconocido';

            // Definimos una categoría fija
            $category = 'Diario Sin Fronteras';

            // Verificamos que se haya extraído el título y el enlace correctamente
            if ($title && $link) {
                // Guardamos la noticia con los datos obtenidos
                $this->saveNoticia($title, $link, $image, $author, $category);
            } else {
                // Si no se encontró título o enlace, mostramos un error
                $this->error("No se encontró el título o enlace de la noticia.");
            }
        });
    }

    public function scrapeCorreo($client)
    {
        $baseUrl = 'https://diariocorreo.pe/';

        $crawler = $client->request('GET', $baseUrl);

        $crawler->filter('.triplet__item')->each(function ($node) use ($client, $baseUrl) {
            $title = $this->getNodeText($node->filter('h2.triplet__title a'));
            $link = $this->getNodeLink($node->filter('h2.triplet__title a'));

            // Obtener la URL relativa de la imagen
            $imageRelativeUrl = $node->filter('figure.triplet__multimedia img')->attr('src');

            // Completar la URL de la imagen si es relativa
            $image = strpos($imageRelativeUrl, 'http') === false ? $baseUrl . $imageRelativeUrl : $imageRelativeUrl;

            // Depuración: Imprimir la URL de la imagen
            echo "Imagen: " . $image . "\n"; // Aquí puedes ver si la URL se genera correctamente

            $author = 'Desconocido';
            $category = 'Diario Correo';

            // Verificar que el título y enlace existan antes de guardar
            if ($title && $link) {
                $this->saveNoticia($title, $link, $image, $author, $category);
            } else {
                $this->error("No se encontró el título o enlace de la noticia.");
            }
        });
    }
    public function scrapeOjo($client)
    {
        // Base URL del Diario Ojo
        $baseUrl = 'https://ojo.pe/';

        // Realizamos la petición HTTP para obtener el contenido de la página
        $crawler = $client->request('GET', $baseUrl);

        // Filtramos las noticias
        $crawler->filter('article.featured-story')->each(function ($node) use ($client, $baseUrl) {
            // Obtener el título de la noticia
            $title = $this->getNodeText($node->filter('h2.featured-story__title a'));

            // Obtener el enlace a la noticia
            $link = $this->getNodeLink($node->filter('h2.featured-story__title a'));

            // Obtener la URL de la imagen desde el atributo data-srcset de la etiqueta <source>
            $imageUrl = $node->filter('picture.featured-story__img-box source')->attr('data-srcset');

            // Si no se encuentra la URL en el atributo data-srcset, intentamos obtenerla desde el <img>
            if (!$imageUrl) {
                $imageUrl = $node->filter('picture.featured-story__img-box img')->attr('src');
            }

            // Autor de la noticia (si no se encuentra, lo dejamos como 'Desconocido')
            $author = $this->getNodeText($node->filter('address.featured-story__author a')) ?: 'Desconocido';

            // Categoría (lo que se encuentra en el <h3> antes del título de la noticia)
            $category = 'Diario Ojo';

            // Verificamos que el título, el enlace y la imagen existan antes de guardar
            if ($title && $link && $imageUrl) {
                $this->saveNoticia($title, $link, $imageUrl, $author, $category);
            } else {
                $this->error("No se encontró el título, enlace o imagen de la noticia.");
            }
        });
    }
    public function scrapeLatina($client)
    {
        // Base URL del portal Latina Noticias
        $baseUrl = 'https://latinanoticias.pe/';

        // Realizamos la petición HTTP para obtener el contenido de la página
        $crawler = $client->request('GET', $baseUrl);

        // Filtramos las noticias
        $crawler->filter('div.n-noticia')->each(function ($node) {
            try {
                // Obtener el título de la noticia
                $title = $this->getNodeText($node->filter('div.n-info-noticia h2.n-info-noticia-titulo a'));

                // Obtener el enlace de la noticia
                $link = $this->getNodeLink($node->filter('div.n-info-noticia h2.n-info-noticia-titulo a'));

                // Obtener la URL de la imagen
                $imageUrl = $node->filter('div.n-noticia-foto img')->count() > 0
                    ? $node->filter('div.n-noticia-foto img')->attr('src')
                    : null;

                // Obtener la fecha de la noticia
                $date = $this->getNodeText($node->filter('span.n-fecha'));

                // Definir el valor que se almacenará en 'autor' (puedes personalizarlo)
                $author = 'Latina'; // Puedes cambiar esto

                // Verificamos que el título, el enlace y la imagen existan antes de guardar
                if ($title && $link && $imageUrl) {
                    // Aquí guardamos el autor y 'Latina Noticias' en category
                    $this->saveNoticia($title, $link, $imageUrl, $author, 'Latina Noticias');
                } else {
                    $this->error("No se encontró el título, enlace o imagen de la noticia.");
                }
            } catch (\Exception $e) {
                $this->error("Error al procesar una noticia: " . $e->getMessage());
            }
        });
    }



}
