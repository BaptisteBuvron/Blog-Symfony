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
        return [
            TextField::new('title', "Titre"),
            TextareaField::new('logoFile', "Le logo")->onlyOnForms()->setFormType(VichImageType::class),
            ImageField::new('logoName', 'logo')->onlyOnDetail()->onlyOnIndex()->setBasePath('/images/logo')->setTemplatePath('/easyadmin/vich_uploader_logo.html.twig'),
            TextField::new('littleDescription', "Petite description"),
            TextEditorField::new('description', "Description"),
            EmailField::new('email', "Email"),
            UrlField::new('insta', 'Instagram'),
            UrlField::new('facebook', 'Facebook'),
            AssociationField::new('presentationArticle')->autocomplete(),
            ImageField::new('imageName', 'image')->onlyOnDetail()->onlyOnIndex()->setBasePath('/images/custom')->setTemplatePath('/easyadmin/vich_uploader_image.html.twig'),
            TextareaField::new('imageFile', "L'image")->onlyOnForms()->setFormType(VichImageType::class),
            BooleanField::new('isActive', "Actif?")
        ];
    }

}
