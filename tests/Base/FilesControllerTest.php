<?php

namespace Base;

use FilePostsInc\Base\FilesController;
use PHPUnit\Framework\TestCase;

class FilesControllerTest extends TestCase
{

    public function testRegister()
    {
        $this->assertTrue(has_action('add_meta_boxes'));
        $this->assertTrue(has_action('save_post_file_post'));
    }

//    public function testMakeFilePostType()
//    {
//
//    }
//
//    public function testMakeShortcodePostType()
//    {
//
//    }
//
//    public function testAddMetaBoxes()
//    {
//
//    }
//
//    public function testMakeFileCategoryTaxonomy()
//    {
//
//    }
}
