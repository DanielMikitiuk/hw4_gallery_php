<?php
class ImageResize
{
    private $image;
    private $image_type;
    private $image_width;
    private $image_height;
    private $dest_width;
    private $dest_height;
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $image_info = getimagesize($filename);
        $this->image_width = $image_info[0];
        $this->image_height = $image_info[1];
        $this->image_type = $image_info['mime'];

        $functionCreate = match ($this->image_type) {
            'image/jpeg'  => 'imagecreatefromjpeg',
            'image/png'   => 'imagecreatefrompng',
            'image/gif'   => 'imagecreatefromgif',
        };
        $this->image = $functionCreate($filename);
    }

    public function save()
    {
        $functionSave = match ($this->image_type) {
            'image/jpeg'  => 'imagejpeg',
            'image/png'   => 'imagepng',
            'image/gif'   => 'imagegif',
        };
        extract(pathinfo($this->filename));
        $functionSave($this->image, "{$dirname}/small_img/{$this->dest_width}x{$this->dest_height}-{$filename}.$extension");

    }

    public function resize($width, $height)
    {
        $this->dest_width = floor($width);
        $this->dest_height = floor($height);
        $dest = imagecreatetruecolor($width, $height);
        imagecopyresampled($dest, $this->image, 0, 0, 0, 0, $width, $height, $this->image_width, $this->image_height);
        $this->image = $dest;
    }

    public function scale($scale)
    {
        $width = $this->image_width * $scale / 100;
        $height = $this->image_height * $scale / 100;
        $this->resize($width, $height);
    }

    public function resizeToWidth($width)
    {
        $ratio = $this->image_width / $width;
        $height = $this->image_height / $ratio;
        $this->resize($width, $height);
    }

    public function resizeToHeight($height)
    {
        $ratio = $this->image_height / $height;
        $width = $this->image_width / $ratio;
        $this->resize($width, $height);
    }
}