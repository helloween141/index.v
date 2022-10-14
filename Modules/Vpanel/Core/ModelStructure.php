<?php

namespace Modules\Vpanel\Core;

use Modules\Vpanel\Core\Fields\Field;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\Fields\TextField;

class ModelStructure
{
    protected array $fields = [];

    protected array $childModel = [];

    protected string $title = '';

    protected string $recordTitle = '';

    protected string $accusativeRecordTitle = '';

    protected string $editorComponent = '';

    protected string $formComponent = '';

    protected bool $sortable = false;

    protected bool $recursive = false;

    protected bool $single = false;

    static function create(): ModelStructure
    {
        return new ModelStructure();
    }

    public function addField(Field $field): ModelStructure
    {
        $this->fields[] = $field;
        return $this;
    }

    public function setModelTitle($title): ModelStructure
    {
        $this->title = $title;
        return $this;
    }

    public function setAccusativeRecordTitle($title): ModelStructure
    {
        $this->accusativeRecordTitle = $title;
        return $this;
    }

    public function setRecordTitle($title): ModelStructure
    {
        $this->recordTitle = $title;
        return $this;
    }

    public function addChildModel(ChildModel $childModel): ModelStructure
    {
        $this->childModel[] = $childModel;
        return $this;
    }

    public function setEditorComponent($name): ModelStructure
    {
        $this->editorComponent = $name;
        return $this;
    }

    public function setFormComponent($name): ModelStructure
    {
        $this->formComponent = $name;
        return $this;
    }

    public function setSortable(): ModelStructure {
        $this->sortable = true;
        return $this;
    }

    public function setRecursive(): ModelStructure {
        $this->recursive = true;
        return $this;
    }

    public function setSingle(): ModelStructure {
        $this->single = true;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getRecordTitle(): string
    {
        return $this->recordTitle;
    }

    public function getAccusativeRecordTitle(): string
    {
        return $this->accusativeRecordTitle;
    }

    public function getEditorComponent(): string
    {
        return $this->editorComponent;
    }

    public function getFormComponent(): string
    {
        return $this->formComponent;
    }

    public function getChildModel(): array
    {
        return $this->childModel;
    }

    public function getIdentifyField(): string
    {
        foreach ($this->getFields() as $field) {
            if ($field->isIdentify()) {
                return $field->getName();
            }
        }
        return '';
    }

    public function addUrl(): ModelStructure
    {
        return $this->addField(StringField::create()->setName('url')->setTitle('URL')->hideFromEditor());
    }

    public function addMeta(): ModelStructure
    {
        return $this->addField(StringField::create()->setName('meta_title')->setTitle('Meta title')->hideFromEditor())
                    ->addField(TextField::create()->setName('meta_description')->setTitle('Meta description')->hideFromEditor());
    }

    public function isSortable(): bool {
        return $this->sortable;
    }

    public function isRecursive(): bool {
        return $this->recursive;
    }

    public function isSingle(): bool {
        return $this->single;
    }
}

