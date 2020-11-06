<?php

namespace Templates;

class FileListTemplate
{
    public function makeFileList($file_posts)
    {
        $html = '
            <table id="example" class="display" style="width: 100%;">
                <thead>
                    <tr>
                    <th>Лого</th>
                    <th>Название</th>
                    <th>Направление</th>
                    <th>Скачать</th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($file_posts as $file_post){
            $name = $file_post->post_title;
            $link = $file_post->attachment_link;
            $type = $this->getMimeType($link);
            $cat = $file_post->terms[0];
            $html .= '
                <tr>
                    <td>'.$type.'</td>
                    <td>'.$name.'</td>
                    <td>'.$cat.'</td>
                    <td><a class="btn btn-primary" href="'.$link.'">Скачать</a></td>
                </tr>';
        }
        $html .= '
                </tbody>
            </table>
        ';

        return $html;
    }

    private function getFileNameFromFileURL($url){
        $pos = strrpos($url, '/');
        return $pos === false ? $url : substr($url, $pos + 1);

    }

    private function getMimeType($url)
    {
        $file_name = $this->getFileNameFromFileURL($url);
        $pos = strrpos($file_name, '.');
        return $pos === false ? $file_name : substr($file_name, $pos + 1);
        return substr($file_name, strrpos($file_name, '.') + 1);
    }
}