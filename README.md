# CIUnit

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

Copy the example test directory into your project:

```bash
cp vendor/Celc/ciunit/tests <project-dir>
```

Create `application/config/testing/database.php` for database testing. The database name must end with "_test".

## Run Tests:

From the `/tests` directory run:

```bash
phpunit
```
