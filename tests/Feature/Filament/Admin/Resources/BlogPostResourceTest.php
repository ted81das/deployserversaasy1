<?php

namespace Feature\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BlogPostResource;
use Tests\Feature\FeatureTest;

class BlogPostResourceTest extends FeatureTest
{
    public function test_list(): void
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        $response = $this->get(BlogPostResource::getUrl('index', [], true, 'admin'))->assertSuccessful();

        $response->assertStatus(200);
    }
}