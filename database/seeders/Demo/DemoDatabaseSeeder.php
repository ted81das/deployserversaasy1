<?php

namespace Database\Seeders\Demo;

use App\Constants\SubscriptionStatus;
use App\Models\BlogPost;
use App\Models\Currency;
use App\Models\Discount;
use App\Models\Interval;
use App\Models\OauthLoginProvider;
use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDatabaseSeeder extends Seeder
{
    private array $blogPostTitles = [
        "The Art of Responsive Web Design: A Comprehensive Guide",
        "Exploring the Power of Machine Learning in Everyday Life",
        "Mastering the Basics: A Beginner's Guide to Python Programming",
        "The Future of Virtual Reality: Trends and Innovations",
        "Sustainable Living: Eco-Friendly Practices for a Greener Planet",
        "Unraveling the Mysteries of Quantum Computing",
        "Crafting Engaging User Experiences: A UX Design Tutorial",
        "Demystifying Blockchain Technology: Beyond Cryptocurrencies",
        "Navigating the World of Cybersecurity: Tips for Online Safety",
        "The Impact of Artificial Intelligence on Healthcare",
        "DIY Home Improvement Projects for a Budget-Friendly Upgrade",
        "Culinary Adventures: Exploring Global Cuisines at Home",
        "Mindfulness in the Digital Age: Finding Balance in a Busy World",
        "Capturing the Perfect Shot: Photography Tips for Beginners",
        "Fitness for All: Tailoring Workouts to Your Lifestyle",
        "Building a Personal Brand: Strategies for Professional Success",
        "The Evolution of Social Media: Trends and Influencer Culture",
        "Unlocking Creativity: A Guide to Overcoming Creative Blocks",
        "The Power of Storytelling: Crafting Compelling Narratives",
        "Remote Work Revolution: Maximizing Productivity in a Virtual World"
    ];

    private array $images = [
        'https://unsplash.com/photos/F1MaILUxscM/download?ixid=M3wxMjA3fDB8MXx0b3BpY3x8d0pMTzN0U0s1QU18fHx8fDJ8fDE3MDY2MTk4NTF8&force=true&w=1920',
        'https://unsplash.com/photos/yGMw4KpX4CE/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI2MDI1fA&force=true&w=1920',
        'https://unsplash.com/photos/DvopK4gNs8A/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI2MDI5fA&force=true&w=1920',
        'https://unsplash.com/photos/c6miNI_WdZ4/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI2MDMxfA&force=true&w=1920',
        'https://unsplash.com/photos/kF5nFbHBG5E/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI2MDMyfA&force=true&w=1920',
        'https://unsplash.com/photos/ck2D9pxRbTo/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjIzNDgxfA&force=true&w=1920',
        'https://unsplash.com/photos/FTUSP0ZH49I/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjIzMDQ3fA&force=true&w=1920',
        'https://unsplash.com/photos/QwAcsiuGTaM/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI3MjI1fA&force=true&w=1920',
        'https://unsplash.com/photos/v4j0rlrTZbc/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI3MjI5fA&force=true&w=1920',
        'https://unsplash.com/photos/IncXhM8rKSc/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjIzOTE1fA&force=true&w=1920',
        'https://unsplash.com/photos/bwcxNg8dkiI/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI3MjQwfA&force=true&w=1920',
        'https://unsplash.com/photos/Kt5hRENuotI/download?ixid=M3wxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNzA2NjI1NDcyfA&force=true&w=1920',
    ];

    private string $loremIpsum = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';

    /**
     * Seed the testing database.
     */
    public function run(): void
    {
        $this->callOnce([
            DatabaseSeeder::class,
        ]);

        // add admin user
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if (!$adminUser) {

            $adminUser = User::factory()->create([
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'name' => 'Admin',
                'public_name' => 'John Doe',
                'is_admin' => true,
            ]);

            $adminUser->assignRole('admin');
        }

        $this->seedDemoData();
        $this->addDiscounts();
        $this->addBlogPosts($adminUser);

        // enable google oauth
        OauthLoginProvider::where('provider_name', 'google')->update(['enabled' => true]);
    }

    private function seedDemoData(): void
    {

        $basicProduct = $this->findOrCreateProduct([
            'name' => 'Basic',
            'slug' => 'basic',
            'description' => 'Basic plan',
            'features' => [["feature"=> "Amazing Feature 1"], ["feature"=> "Amazing Feature 2"], ["feature"=> "Amazing Feature 3"], ["feature"=> "Amazing Feature 4"], ["feature"=> "Amazing Feature 5"]],
        ]);

        $proProduct = $this->findOrCreateProduct([
            'name' => 'Pro',
            'slug' => 'pro',
            'description' => 'Pro plan',
            'is_popular' => true,
            'features' => [["feature"=> "Amazing Feature 1"], ["feature"=> "Amazing Feature 2"], ["feature"=> "Amazing Feature 3"], ["feature"=> "Amazing Feature 4"], ["feature"=> "Amazing Feature 5"]],
        ]);

        $ultimateProduct = $this->findOrCreateProduct([
            'name' => 'Ultimate',
            'slug' => 'ultimate',
            'description' => 'Ultimate plan',
            'features' => [["feature"=> "Amazing Feature 1"], ["feature"=> "Amazing Feature 2"], ["feature"=> "Amazing Feature 3"], ["feature"=> "Amazing Feature 4"], ["feature"=> "Amazing Feature 5"]],
        ]);

        $this->createPlans($basicProduct, 1000, 10000);
        $this->createPlans($proProduct, 2500, 25000);
        $this->createPlans($ultimateProduct, 5000, 50000);
    }

    private function findOrCreateProduct(array $data)
    {
        $product = Product::where('slug', $data['slug'])->first();

        if ($product) {
            return $product;
        }

        return Product::create($data);
    }

    private function createPlans(Product $product, $priceMonthly, $priceYearly): void
    {
        $basicPlan = $this->findOrCreatePlan([
            'name' => $product->name . ' Monthly',
            'slug' => $product->slug . '-monthly',
            'interval_id' => Interval::where('slug', 'month')->first()->id,
            'interval_count' => 1,
            'trial_interval_id' => Interval::where('slug', 'week')->first()->id,
            'has_trial' => true,
            'trial_interval_count' => 1,
            'is_active' => true,
            'product_id' => $product->id,
        ]);

        $basicPlan->prices()->create([
            'currency_id' => Currency::where('code', 'USD')->first()->id,
            'price' => $priceMonthly,
        ]);

        $this->addPlanSubscriptions($basicPlan);

        // add yearly plan

        $basicPlan = $this->findOrCreatePlan([
            'name' => $product->name . ' Yearly',
            'slug' => $product->slug . '-yearly',
            'interval_id' => Interval::where('slug', 'year')->first()->id,
            'interval_count' => 1,
            'trial_interval_id' => Interval::where('slug', 'week')->first()->id,
            'has_trial' => true,
            'trial_interval_count' => 1,
            'is_active' => true,
            'product_id' => $product->id,
        ]);

        $basicPlan->prices()->create([
            'currency_id' => Currency::where('code', 'USD')->first()->id,
            'price' => $priceYearly,
        ]);

        $this->addPlanSubscriptions($basicPlan);

    }

    private function findOrCreatePlan(array $data)
    {
        $plan = Plan::where('slug', $data['slug'])->first();

        if ($plan) {
            return $plan;
        }

        return Plan::create($data);
    }

    private function addPlanSubscriptions(Plan $plan): void
    {
        $numberOfUsers = rand(15, 25);

        for ($i = 0; $i < $numberOfUsers; $i++) {

            $numberOfIntervalsBack = rand(10, 20);
            $createdDate = now()->sub($plan->interval->date_identifier, $numberOfIntervalsBack);

            $user = User::factory()->create(
                [
                    'created_at' => $createdDate,
                    'updated_at' => $createdDate,
                ]
            );

            $status = rand(0, 1) === 1 ? SubscriptionStatus::ACTIVE : SubscriptionStatus::CANCELED;

            $subscription = $user->subscriptions()->create([
                'plan_id' => $plan->id,
                'trial_ends_at' => null,
                'ends_at' => $status == SubscriptionStatus::ACTIVE ? Carbon::now()->add(1, $plan->interval->date_identifier): Carbon::now()->sub(1, $plan->interval->date_identifier),
                'price' => $plan->prices()->first()->price,
                'currency_id' => $plan->prices()->first()->currency_id,
                'user_id' => $user->id,
                'uuid' => Str::uuid(),
                'status' => rand(0, 1) === 1 ? SubscriptionStatus::ACTIVE : SubscriptionStatus::CANCELED,
                'payment_provider_id' => 1,
                'interval_id' => $plan->interval->id,
                'interval_count' => $plan->interval_count,
                'created_at' => $createdDate,
            ]);

            // add transactions

            $transactionCreatedDate = $createdDate;
            for ($j = 0; $j < $numberOfIntervalsBack; $j++) {
                $user->transactions()->create([
                    'subscription_id' => $subscription->id,
                    'amount' => $plan->prices()->first()->price,
                    'currency_id' => $plan->prices()->first()->currency_id,
                    'payment_provider_id' => 1,
                    'payment_provider_transaction_id' => Str::uuid(),
                    'payment_provider_status' => 'paid',
                    'status' => 'success',
                    'user_id' => $user->id,
                    'uuid' => Str::uuid(),
                    'created_at' => $transactionCreatedDate,
                    'updated_at' => $transactionCreatedDate,
                ]);

                $transactionCreatedDate = $transactionCreatedDate->add(1, $plan->interval->date_identifier);
            }

        }

    }

    private function addDiscounts()
    {
        $discountsToAdd = rand(5, 10);

        for ($i = 0; $i < $discountsToAdd; $i++) {
            $discount = Discount::create([
                'name' => 'Discount ' . $i,
                'amount' => rand(10, 70),
                'type' => 'percentage',
                'valid_until' => null,
                'max_redemptions' => -1,
                'max_redemptions_per_user' => -1,
                'is_recurring' => true,
                'is_active' => true,
            ]);

            // add code to discount
            $discount->codes()->create([
                'code' => Str::random(10),
            ]);
        }
    }

    private function addBlogPosts(User $user)
    {
        foreach ($this->blogPostTitles as $title) {

            BlogPost::flushEventListeners();  // disable event listeners in booted method

            $blog = BlogPost::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'body' => str_repeat('<p>' . $this->loremIpsum . '</p>', rand(10, 15)),
                'is_published' => true,
                'published_at' => now()->sub(rand(1, 10), 'days'),
                'user_id' => $user->id,
                'author_id' => $user->id,
            ]);

            // assign an image to the blog post using spatie media library

            $blog->addMediaFromUrl($this->images[rand(0, count($this->images) - 1)])
                ->toMediaCollection('blog-images');
        }
    }


}
