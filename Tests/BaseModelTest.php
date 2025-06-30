<?php 
use PHPUnit\Framework\TestCase;
use Carbe\App\Models\BaseModel;


class BaseModelTest extends TestCase
{
    public function testInsert()
    {
        $pdoMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $pdoMock->expects($this->once())
                ->method('prepare')
                ->with("INSERT INTO users (name, age) VALUES (:name, :age)")
                ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with([
                     'name' => 'John',
                     'age' => 32
                 ]);

        $model = new class($pdoMock) extends BaseModel {
            public function __construct($pdo) {
                parent::__construct($pdo);
                $this->table = 'users';
            }
        };

        $model->insert([
            'name' => 'John',
            'age' => 32
        ]);
    }
}

// ./vendor/bin/phpunit tests/BaseModelTest.php