<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Customisation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CustomisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customisation::class;
    }


    public function configureFields(string $pageName): iterable
    {

        $fields = [
            TextField::new('title', "Titre"),
            TextField::new('littleDescription', "Petite description"),
            TextEditorField::new('description', "Description"),
            EmailField::new('email', "Email"),
            UrlField::new('insta','Instagram'),
            UrlField::new('facebook','Facebook'),
            AssociationField::new('presentationArticle')->autocomplete()
        ];
        $imageFile = TextareaField::new('imageFile', "L'image")->setFormType(VichImageType::class);
        $image =  ImageField::new('imageName', 'image')->setBasePath('/images/custom')->setTemplatePath('/easyadmin/vich_uploader_image.html.twig');
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        }
        else {
            $fields[] = $imageFile;
        }
        array_push($fields,
            TextareaField::new('imageFile', "L'image")->setFormType(VichImageType::class),
            BooleanField::new('isActive', "Actif?")
        );
        return $fields;
    }

}
