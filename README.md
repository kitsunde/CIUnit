# CIUnit

## Examples

### Controller

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
    }

## Add via composer

    composer require Celc/ciunit dev-master

Copy the example test directory into your project:

    cp vendor/Celc/ciunit/tess <project-dir>

Create `application/config/testing/database.php` for database testing. The database name must end with "_test".

## Run Tests:

From the `/tests` directory run:

	phpunit
