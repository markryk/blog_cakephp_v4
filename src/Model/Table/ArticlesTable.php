<?php
    // src/Model/Table/ArticlesTable.php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\Utility\Text; //the Text class
    use Cake\Event\EventInterface; //the EventInterface class
    use Cake\Validation\Validator; //the Validator class

    class ArticlesTable extends Table {
        public function initialize(array $config): void {
            $this->addBehavior('Timestamp');
        }

        //Adding Simple Slug Generation
        public function beforeSave(EventInterface $event, $entity, $options) {
            if ($entity->isNew() && !$entity->slug) {
                $sluggedTitle = Text::slug($entity->title);
                // trim slug to maximum length defined in schema
                $entity->slug = substr($sluggedTitle, 0, 191);
            }
        }

        public function validationDefault(Validator $validator): Validator {
            $validator
                ->notEmptyString('title')
                ->minLength('title', 10)
                ->maxLength('title', 255)

                ->notEmptyString('body')
                ->minLength('body', 10);

            return $validator;
        }
    }
?>
