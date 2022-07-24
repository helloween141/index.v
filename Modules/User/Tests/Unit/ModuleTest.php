<?php

namespace Modules\User\Tests\Unit;

use Modules\Vpanel\Core\Fields\SelectField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    public function test_get_menu() {

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_model_structure()
    {
        $modelStructure = new ModelStructure();

        $modelStructure
            ->addField((new StringField('email'))->setTitle('Email')->required()->identify())
            ->addField((new SelectField('payments'))->setTitle('Payments')->setOptions([
                '1' => 'one',
                '2' => 'two'
            ]))
            ->setModelTitle('Test')
            ->setRecordTitle('Test')
            ->setAccusativeRecordTitle('Test');

        dd($modelStructure);
        $this->assertTrue(true);
    }
}
