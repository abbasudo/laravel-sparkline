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
     * @var int[]
     */
    private array $color = [219, 211, 44, 1];

    /**
     * @var int[]
     */
    private array $background = [0, 0, 0, 0];

    /**
     * @var int[]
     */
    private array $fill = [219, 211, 44, 0.5];

    /**
     * @var Collection
     */
    private Collection $data;

    /**
     * @var \Intervention\Image\Image
     */
    private \Intervention\Image\Image $image;

    /**
     * @var integer
     */
    private int $thickness = 2;

    public function __construct()
    {
        $this->image = Image::canvas($this->width, $this->height);
    }

    public function render()
    {
        $this->image->fill($this->background);

        imagesetthickness($this->image->getCore(), $this->thickness);

        $this->draw();

        $this->image->fill($this->fill, 1, 1);

        $this->image->flip('vertical');

        return $this->image;
    }

    private function draw()
    {
        $step = $this->width / ($this->data->count() - 1);

        $base = 0;

        $this->data->each(function ($item, $key) use ($step, &$base) {
            if ($item === $this->data->last()) {
                return false;
            }
            $this->image->line(
                $base,
                round($this->height / ($this->data->max() / ($item + $this->thickness))),
                $base + $step,
                round($this->height / ($this->data->max() / ($this->data[$key + 1] + $this->thickness))),
                function ($draw) {
                    $draw->color($this->color);
                }
            );
            $base += $step;
        });
    }

    public function data(array $data)
    {
        $this->data = collect($data);

        $this->data->transform(
            fn($item) => $item - $this->data->min()
        );

        return $this;
    }

    public function color(int $red, int $green, int $blue, int $alpha = 1)
    {
        $this->color = [$red, $green, $blue, $alpha];

        return $this;
    }

    public function fill(int $red, int $green, int $blue, int $alpha = 1)
    {
        $this->fill = [$red, $green, $blue, $alpha];

        return $this;
    }

    public function background(int $red, int $green, int $blue, int $alpha = 1)
    {
        $this->background = [$red, $green, $blue, $alpha];

        return $this;
    }

    public function thickness(int $thickness)
    {
        $this->thickness = $thickness;

        return $this;
    }
}
