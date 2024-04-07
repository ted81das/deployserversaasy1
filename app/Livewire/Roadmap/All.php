<?php

namespace App\Livewire\Roadmap;

use App\Services\RoadmapManager;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    public function render(RoadmapManager $roadmapManager)
    {
        return view('livewire.roadmap.all', [
            'items' => $roadmapManager->getAll()
        ]);
    }

    public function upvote(int $id, RoadmapManager $roadmapManager)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $roadmapManager->upvote($id);
    }

    public function removeUpvote(int $id, RoadmapManager $roadmapManager)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $roadmapManager->removeUpvote($id);
    }
}
