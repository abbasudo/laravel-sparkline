<?php

namespace Llabbasmkhll\LaravelSparkline;

use Intervention\Image\Facades\Image;

class Sparkline extends Image
{
    /**
     * @var int
     */
    private int $height = 80;

    /**
     * @var int
     */
    private int $width = 200;

    /**
     * @var int|false
     */
    private int|false $color;

    public function create()
    {
        return Image::canvas(100, 100)->opacity(100)->line(0, 0, 100, 100,)->fill('#cccccc',0,75);
    }

    public function save(string $path)
    {
        return imagepng($this->image, $path);
    }

    public function red($alpha = 0)
    {
        $this->color(250, 0, 0, $alpha);

        return $this;
    }

    public function color(int $red, int $green, int $blue, int $alpha)
    {
        $this->color = imagecolorallocatealpha($this->image, $red, $green, $blue, $alpha);

        return $this;
    }

    public function blue($alpha = 0)
    {
        $this->color(0, 0, 250, $alpha);

        return $this;
    }

    public function green($alpha = 0)
    {
        $this->color(0, 250, 0, $alpha);

        return $this;
    }

    public function fill(?int $x, ?int $y)
    {
        imagefill($this->image, $x ?? $this->height / 2, $y ?? $this->width / 2, $this->color);

        return $this;
    }

    public function line(array $from, array $to)
    {
        imageline($this->image, $from['x'], $from['y'], $to['x'], $to['y'], $this->color);

        return $this;
    }
}
