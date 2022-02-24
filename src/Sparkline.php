<?php

namespace Llabbasmkhll\LaravelSparkline;

use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;

class Sparkline
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
    private array $color = [219, 211, 44, 1.0];

    /**
     * @var int[]
     */
    private array $background = [0, 0, 0, 0];

    /**
     * @var int[]
     */
    private array $fill = [219, 211, 44, 0];

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

    /**
     * @var float
     */
    private float $offset = 0.2;

    public function __construct()
    {
        $this->image = Image::canvas($this->width, $this->height);
    }

    /**
     * @return \Intervention\Image\Image
     */
    public function render(): \Intervention\Image\Image
    {
        $this->image->fill($this->background);

        imagesetthickness($this->image->getCore(), $this->thickness);

        $this->draw();

        $this->image->fill($this->fill, 1, 1);

        $this->image->flip('vertical');

        return $this->image;
    }

    /**
     * @return void
     */
    private function draw(): void
    {
        $step = $this->width / ($this->data->count() - 1);

        $height = $this->height - $this->thickness * 2;

        $base = 0;

        $this->data->each(function ($item, $key) use ($height, $step, &$base) {
            if ($item === $this->data->last()) {
                return false;
            }
            $this->image->line(
                $base,
                round($height / ($this->data->max() / ($item + 1))) + $this->thickness,
                $base + $step,
                round($height / ($this->data->max() / ($this->data[$key + 1] + 1))) + $this->thickness,
                function ($draw) use ($key) {
                    // make the line color transparent and get colored at the end of the line
                    $this->alpha($this->data->count() / 100 * $key / 100 + $this->offset);
                    $draw->color($this->color);
                }
            );
            $base += $step;
        });
    }

    /**
     * @param  float  $alpha
     *
     * @return $this
     */
    public function alpha(float $alpha): static
    {
        if ($alpha > 1) {
            $alpha = 1;
        }

        $this->color[3] = $alpha;

        return $this;
    }

    /**
     * @param  array  $data
     *
     * @return $this
     */
    public function data(array $data): static
    {
        $this->data = collect($data);

        // normalize data
        $this->data->transform(
            fn($item) => ($item - $this->data->min()) * 1000000000000
        );

        return $this;
    }

    /**
     * @param  int  $red
     * @param  int  $green
     * @param  int  $blue
     * @param  int  $alpha
     *
     * @return $this
     */
    public function color(int $red, int $green, int $blue, int $alpha = 1): static
    {
        if ($alpha > 1) {
            $alpha = 1;
        }

        $this->color = [$red, $green, $blue, $alpha];

        return $this;
    }

    /**
     * @param  int  $red
     * @param  int  $green
     * @param  int  $blue
     * @param  int  $alpha
     *
     * @return $this
     */
    public function fill(int $red, int $green, int $blue, int $alpha = 1): static
    {
        $this->fill = [$red, $green, $blue, $alpha];

        return $this;
    }

    /**
     * @param  int  $red
     * @param  int  $green
     * @param  int  $blue
     * @param  int  $alpha
     *
     * @return $this
     */
    public function background(int $red, int $green, int $blue, int $alpha = 1): static
    {
        $this->background = [$red, $green, $blue, $alpha];

        return $this;
    }

    /**
     * @param  int  $thickness
     *
     * @return $this
     */
    public function thickness(int $thickness): static
    {
        $this->thickness = $thickness;

        return $this;
    }

    /**
     * @param  float  $offset
     *
     * @return $this
     */
    public function offset(float $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param  int  $width
     * @param  int  $height
     *
     * @return $this
     */
    public function size(int $width, int $height): static
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }
}
