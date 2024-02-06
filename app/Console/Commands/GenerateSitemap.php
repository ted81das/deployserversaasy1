<?php

namespace App\Console\Commands;

use App\Services\BlogManager;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BlogManager $blogManager)
    {

         $routes = collect(Route::getRoutes()->getRoutes())->filter(function (\Illuminate\Routing\Route $route) {

             if (!in_array('GET', $route->methods)) {
                    return false;
             }

             if (!isset($route->action['middleware']) || !is_array($route->action['middleware'])) {
                 return false;
             }

             if (in_array('sitemapped', $route->action['middleware'])) {
                 return true;
             }

             return false;
         })->map(function ($route) {
             return route($route->getName());
         })->values()->toArray();

         // go through all blog posts and add them to the sitemap (chunked to avoid memory issues)

        $blogManager->getAllPostsQuery()->chunk(100, function ($posts) use (&$routes) {
            foreach ($posts as $post) {
                $routes[] = route('blog.view', $post->slug);
            }
        });

        $sitemap = Sitemap::create();

        foreach ($routes as $route) {
            $sitemap->add($route);
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        // add the sitemap to robots.txt
        $robots = file_get_contents(public_path('robots.txt'));

        $sitemap1 = "Sitemap: " . url('sitemap.xml');

        if (!str_contains($robots, $sitemap1)) {
            $robots .= "\n\n" . $sitemap1;
            file_put_contents(public_path('robots.txt'), $robots);
        }

        // add docs sitemap to robots.txt
        $sitemap2 = "Sitemap: " . url('docs/sitemap.xml');

        if (!str_contains($robots, $sitemap2)) {
            $robots .= "\n\n" . $sitemap2;
            file_put_contents(public_path('robots.txt'), $robots);
        }
    }
}
