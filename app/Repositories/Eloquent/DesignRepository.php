<?php

namespace App\Repositories\Eloquent;

use App\Models\Design;
use App\Repositories\Contracts\IDesign;

class DesignRepository extends BaseRepository implements IDesign
{
    public function model()
    {
        return Design::class; // 'App\Models\Design'
    }

    public function applyTags($id, array $data)
    {
        $design = $this->find($id);
        $design->retag($data);
    }

    public function addComment($designId, array $data)
    {
        //get the design for which we want to create a comment
        $design = $this->find($designId);

        //create comment for the design
        $comment = $design->comments()->create($data);

        return $comment;
    }

}