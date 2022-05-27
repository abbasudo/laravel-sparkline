# laravel-sparkline
Generate small chart and sparklines in your laravel app like a breeze.<br>
this package helps you to plot prices of stock ,currencies ,crypto, etc, into an image in your laravel app.<br>
it uses [image intervention](https://image.intervention.io/v2) and [PHP gd](https://www.php.net/manual/en/book.image.php) to generate the image.

<br />
<br />

<!-- INSTALLATION -->
## Installation 
```shell
composer require llabbasmkhll/laravel-sparkline
```

<br />
<br />

<!-- USAGE -->
## Usage
to use sparkline all you have to is providing the numbers that you want to plot to data function and render the chart like below:
```php
$metrics = [76, 80, 50, 62, 32, 55, 42, 5, 10, 2, 22, 5, 6, 26, 25, 55, 40, 32, 55, 42, 5, 10, 2, 22, 56];

return Sparkline::data($metrics)->render()->response('png');
```
this will generate an sparkline like this:<br>
![sparkline](https://user-images.githubusercontent.com/86796762/170678251-11c4835a-f00b-4a92-b62c-fe0d66f02e24.png)

### Note
`render()` will return an `Intervention\Image` object. more information in [image intervention](https://image.intervention.io/v2).<br>
if your too lazy to read intervention docs simply use `->response('png')` to return the sparkline to the browser or `->save('public/fou.jpg')` to save the sparkline.

<br />
<br />

<!-- CUSTOMIZATION -->
## Customization
### Color
#### line
set the color of the sparkline by `color` function. by defult its yellow.
```php
$red   = 250;
$green = 100;
$blue  = 100;
$alpha = 1;

Sparkline::data($metrics)->color($red, $green, $blue, $alpha)->render()->response('png');
```
![d8l94xyhh](https://user-images.githubusercontent.com/86796762/170679405-ed38cb2b-5c75-41bf-82bb-25a07872837e.png)
#### background
set the background color by `backgorund` function. by defult its transparent.
```php
$red   = 250;
$green = 70;
$blue  = 70;
$alpha = 0.2;

Sparkline::data($metrics)->backgound($red, $green, $blue, $alpha)->render()->response('png');
```
![KTGrO6VsI](https://user-images.githubusercontent.com/86796762/170682706-77515cd5-4e2a-449a-a497-cc6cdddec08b.png)
#### fill
to fill the sparkline use `fill` function. by defult its transparent.
```php
$red   = 250;
$green = 70;
$blue  = 70;
$alpha = 0.2;

Sparkline::data($metrics)->fill($red, $green, $blue, $alpha)->render()->response('png');
```
![a4OK4h092](https://user-images.githubusercontent.com/86796762/170683086-e7fefbc6-5358-4f60-9abd-0e4d5ed51dd8.png)
### Thickness
set line thikness by calling `thickness` like so :
```php
Sparkline::data($metrics)->thikness(3)->render()->response('png');
```
![z_qh8IEhz](https://user-images.githubusercontent.com/86796762/170683690-ba9b1498-1ede-4fcd-9ed0-bf1aca66189b.png)
### Fade
by defult sparklines made with faded color in the begining of the line. to customize it use `fade`.
```php
Sparkline::data($metrics)->fade(0.2)->render()->response('png');
```
![FCRHK8Zpq](https://user-images.githubusercontent.com/86796762/170690936-90bd2e77-0f5d-4e2d-8c98-de9fbde4d022.png)<br>
1.0 to maximum fade and 0.0 to remove the fade 
### Size
to change the size of the sparkline use `size`. the defult size is 80px for height and 200px for width.
```php
$width = 500;
$height = 100;

Sparkline::data($metrics)->size($width, $height)->render()->response('png');
```
![9Sbe60Lvx](https://user-images.githubusercontent.com/86796762/170690363-6078132c-ae35-46e3-b479-82888f46366a.png)

use `width` and `heigt` to change the size seperatly.
```php
Sparkline::data($metrics)->width(400)->render()->response('png');

Sparkline::data($metrics)->height(100)->render()->response('png');

Sparkline::data($metrics)->width(300)->height(80)->render()->response('png');
```

<br />
<br />

## Example
SparklineController.php
```php
class SparklineController extends Controller
{
    public function index(Currency $currency)
    {
        $metrics   = Coingecko::getMetrics($currency->code);
        $sparkline = Sparkline::data($metrics);

        if ($metrics[0] - end($metrics) > 0) {
            $sparkline->color(250, 100, 100);
        } elseif ($metrics[0] - end($metrics) < 0) {
            $sparkline->color(100, 250, 100);
        }

        return $sparkline->render()->response('png');
    }
}
```
web.php
```php
Route::get('/currencies/{currency}/sparkline.png', [SparklineController::class, 'index'])->name('currencies.sparkline');
```

<br />
<br />

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

<br />
<br />

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<br />
<br />

<!-- CONTACT -->
## Contact

Abbas mkhzomi - [Telegram@llabbasmkhll](https://t.me/llabbasmkhll) - llabbasmkhll@gmail.com

Project Link: [https://github.com/llabbasmkhll/laravel-sparkline](https://github.com/llabbasmkhll/laravel-sparkline)

