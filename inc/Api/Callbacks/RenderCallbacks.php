<?php


namespace FilePostsInc\Api\Callbacks;


use FilePostsTemplates\FileListTemplate;

class RenderCallbacks
{

    public function renderFileListShortcode($atts=array())
    {
        $fileListTemplate = new FileListTemplate();
        $category_id = '';
        if (key_exists('cat_id', $atts))
        {
            $category_id = $atts['cat_id'];
        }
        $fileList = $this->getFileList($category_id);
        return $fileListTemplate->makeFileList($fileList);
    }

    private function getFileList($category_id)
    {
        $posts = get_posts( array(
            'post_type' => 'file_post',
            'tax_query' => array(
                array (
                    'taxonomy' => 'file_category',
                    'field' => 'slug',
                    'terms' => $category_id,
                )
            ),
        ) );

        $file_posts = [];
        foreach ($posts as $post){
            $meta = get_post_meta($post->ID, '_file_post_meta_key', true);
            $post->{'attachment_link'} = $meta['attachment_link'];
            $post->{'terms'} = wp_get_post_terms($post->ID, 'file_category', array('fields' => 'names'));
            $file_posts[] = $post;
        }
        return $file_posts;
    }


}