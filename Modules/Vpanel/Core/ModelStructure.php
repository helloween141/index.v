<?php

namespace Modules\Vpanel\Core;

use Modules\Vpanel\Core\Fields\Field;

class ModelStructure
{
    protected array $fields = [];

    protected string $masterModel = '';

    protected string $title = '';

    protected string $recordTitle = '';

    protected string $accusativeRecordTitle = '';

    protected string $editorComponent = '';

    protected string $formComponent = '';

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

    public function setMasterModel($model): ModelStructure
    {
        $this->masterModel = $model;
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

    public function getMasterModel(): string
    {
        return $this->masterModel;
    }

    public function getRequiredFields(): array
    {
        $required = [];
        foreach ($this->getFields() as $field) {
            if ($field->isRequired()) {
                $required = [
                    ...$required,
                    $field->getName() => 'required'
                ];
            }
        }

        return $required;
    }

    public function getPointerFields(): array
    {
        $pointers = [];
        foreach ($this->getFields() as $field) {
            if ($field->isPointer()) {
                $pointers = [
                    ...$pointers,
                    $field->getName() => $field->model
                ];
            }
        }

        return $pointers;
    }

    public function getIdentifyField(): ?Field
    {
        foreach ($this->getFields() as $field) {
            if ($field->isIdentify()) {
                return $field;
            }
        }

        return null;
    }

    public function addUrl(): ModelStructure
    {
        return $this->addField(Field::create('string')->setName('url')->setTitle('URL')->hideFromEditor());
    }

    public function addMeta(): ModelStructure
    {
        return $this->addField(Field::create('string')->setName('meta_title')->setTitle('Meta title')->hideFromEditor())
                    ->addField(Field::create('text')->setName('meta_description')->setTitle('Meta description')->hideFromEditor());
    }
}

