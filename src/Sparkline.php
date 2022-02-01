<?php

namespace Llabbasmkhll\LaravelSparkline;

use Illuminate\Support\Collection;
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
     * @var array
     */
    private array $color = [255, 255, 0, 1];

    /**
     * @var Collection
     */
    private Collection $data;

    public function create()
    {
        $step = $this->width / $this->data->count();

        $this->data->transform(function ($item) {
            return $item * $this->data->min();
        });

        $image = Image::canvas($this->height, $this->height)->opacity(100);

        $base = 0;

        $this->data->each(function ($item, $key) use ($step, $image, &$base) {
            if ($item === $this->data->last()) {
                return false;
            }
            $image->line(
                $base,
                $this->height / ($this->data->max() / $item),
                $base + $step,
                $this->height / ($this->data->max() / $this->data[$key + 1]),
                function ($draw) {
                    $draw->color($this->color);
                }
            );
            $base += $step;
        });


        return $image->response('png');
    }

    public function save(string $path)
    {
        return imagepng($this->image, $path);
    }

    public function data(array $data)
    {
        $this->data = collect($data);

        return $this;
    }

    public function red($alpha = 1)
    {
        $this->color(250, 0, 0, $alpha);

        return $this;
    }

    public function color(int $red, int $green, int $blue, int $alpha = 1)
    {
        $this->color = [$red, $green, $blue, $alpha];

        return $this;
    }

    public function blue($alpha = 1)
    {
        $this->color(0, 0, 250, $alpha);

        return $this;
    }

    public function green($alpha = 1)
    {
        $this->color(0, 250, 0, $alpha);

        return $this;
    }

    public function fill(?int $x, ?int $y)
    {
        imagefill($this->image, $x ?? $this->height / 2, $y ?? $this->width / 2, $this->color);

        return $this;
    }
}
