<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use CoreBundle\Entity\News;
use CoreBundle\Entity\Topic;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenFileIdType;


class NewsType extends AbstractType
{
    private function topicChoices()
    {
        $topisc = $this->getDoctrine()->getRepository(Topic::class)->findAll();

        return $topisc;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true
            ])
            ->add('body', TextareaType::class, [
                'required' => true,
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'News content',
                    'rows' => 3,
                ],
            ]))
            ->add('topic', ChoiceType::class, [
                'expanded' => true,
                'choices' => $this->topicChoices(),
                'multipe' => true,
            ])
            ->add('cover', HiddenFileIdType::class, [
                'required' => false,
                'empty_data' => null,
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
