<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>
{% extends 'base.html.twig' %}

{% set edit = form.vars.value.id != null %}

{% import 'app/_macro_form.html.twig' as macro_form %}

{% block body %}
    {{ form_start(form, {'attr': {'class' : 'horizontal-form','novalidate': 'novalidate'} }) }}
    {% include ('app/_fields_errors.html.twig') %}

    <div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
				<span class="card-icon"><i class="flaticon-search text-primary"></i></span>
				<h3 class="card-label">Crear <?= $entity_class_name;?></h3>
			</div>
        </div>

        <div class="card-body">
            <div class="row">
                <?php $index = 0; ?>
                <?php foreach ($entity_fields as $form_field => $typeOptions): ?>
                    <?php if (!in_array($form_field, $excludedVariables)): ?>
                        <?php $div_width = $typeOptions['type'] == 'boolean' ? 2 : 4;
                            $index += $div_width;?>
                {{ macro_form._new_field(form.<?= $form_field;?>, 'col-md-<?= $div_width;?>') }}
                        <?php if($index % 12 == 0):?>
                        </div>
                        <div class="row">
                        <?php endif;?>                        
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php foreach ($association_fields as $associationField): ?>
                    <?php if (!in_array($associationField['fieldName'], $excludedVariables)): ?>
                        <?php $div_width = 4;
                            $index += $div_width;?>
                {{ macro_form._new_field(form.<?= $associationField['fieldName'];?>, 'col-md-<?= $div_width;?>') }}
                        <?php if($index % 12 == 0):?>
                        </div>
                        <div class="row">
                        <?php endif;?>                        
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ path('<?= $route_name;?>_index') }}" class="btn btn-light-dark font-weight-bold">Volver</a>
            {{ form_widget(form.submit) }}
        </div>
    </div>
    {{ form_widget(form._token) }}
    {{ form_end(form, {"render_rest": false}) }}

{% endblock %}

{% block javascripts %}

    {{ parent() }}

    <script src="{{ asset(__PREFIX_JAVASCRIPT__ ~ 'config/config-form.js') }}" ></script>
    <script src="{{ asset(__PREFIX_JAVASCRIPT__ ~ 'app/<?= $js_path;?>/new.js') }}" ></script>

{% endblock %}
