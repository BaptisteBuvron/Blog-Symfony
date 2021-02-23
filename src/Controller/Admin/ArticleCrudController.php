<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\GalleryType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = TextareaField::new('imageFile', "L'image")->setFormType(VichImageType::class);
        $image =  ImageField::new('imageName', 'image')->setBasePath('/images/article')->setTemplatePath('/easyadmin/vich_uploader_image.html.twig');
        $fiedls = [
            TextField::new('title','Titre'),
            TextField::new('introduction','Introduction'),
            TextareaField::new('content', 'Contenu')->setFormType(CKEditorType::class),
            CollectionField::new('galleries', 'Les images')
                ->setEntryType(GalleryType::class)
                ->onlyOnForms()

        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
            $fiedls[] = $image;
        }
        else{
            $fiedls[] = $imageFile;
        }
        return $fiedls;
    }

    /**
     * Ajout du thème formulaire de Ckeditor
     * @param Crud $crud
     * @return Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

}
