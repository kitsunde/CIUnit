# CIUnit for CodeIgniter 2

**Note:** This is not compatible with CodeIgniter 3. The original creator of my-ciunit has a new project for that here: [https://github.com/kenjis/ci-phpunit-test](https://github.com/kenjis/ci-phpunit-test).

## Examples

### Controller

```php
class LoginActionTest extends CIUnit_TestCase
{
    public function setUp()
    {
        $this->CI = set_controller('login');
    }

    public function testLogin()
    {
        $_POST['useremail'] = 'kitsunde@example.org';
        $_POST['password'] = '123';
        $this->CI->login_action();
        $out = output();
        $this->assertRedirects($GLOBALS['OUT'], 'employee/index');
    }

    public function testTemplateRendered()
    {
        $this->CI->login_action();
        $views = output_views();
        $this->assertContains('login', $views);
    }
}
```

## Install via composer

```bash
composer require Celc/ciunit dev-master
```

Copy the example test directory into the root of your project (same folder as `application` and `system`):

```bash
cp -R vendor/celc/ciunit/tests ./
```

Create `application/config/testing/database.php` for database testing. The database name must end with `_test`.

## Writing tests

The `tests` directory is an example. You are meant to replace the tests with your own.

## Run Tests:

From the `tests` directory run:

```bash
../vendor/phpunit
```
