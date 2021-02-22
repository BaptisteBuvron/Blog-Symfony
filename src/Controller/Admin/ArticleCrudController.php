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
use Symfony\Component\DomCrawler\Image;
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
            TextEditorField::new('introduction','Introduction'),
            TextEditorField::new('content', 'Contenu'),
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

}
