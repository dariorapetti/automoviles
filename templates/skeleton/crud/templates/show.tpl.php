<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>
{% extends 'base.html.twig' %}

{% import 'app/_macro_show.html.twig' as macro_show %}

{% block body %}

    <div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
				<span class="card-icon"><i class="flaticon-search text-primary"></i></span>
				<h3 class="card-label">Detalles del <?= $route_name;?> {{ entity }}</h3>
			</div>
            <div class="card-toolbar">
				<!--begin::Button-->
				<a href="{{ path('<?= $route_name;?>_edit', {'id': entity.id}) }}" class="btn btn-primary font-weight-bolder">
					<i class="la la-pen"></i>
					Editar
				</a>
				<!--end::Button-->
			</div>
        </div>

        <div class="card-body">
            <!--begin::Item-->
            <div class="row">
            <?php $index = 0; 
                $search  = array('_', 'ñ', 'cion');
                $replace = array(' ', '&ntilde;', 'ci&oacute;n');?>
                <?php foreach ($entity_fields as $form_field => $typeOptions): ?>
                    <?php if (!in_array($form_field, $excludedVariables)): ?>
                        <?php $div_width = $typeOptions['type'] == 'boolean' ? 2 : 4;
                            $index += $div_width;?>
                {{ macro_show._show_detail('<?= ucfirst(str_replace($search, $replace, $form_field));?>', entity.<?= $form_field;?>, 'col-md-<?= $div_width;?>') }}
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
                {{ macro_show._show_detail('<?= ucfirst(str_replace($search, $replace, $associationField['fieldName']));?>', entity.<?= $associationField['fieldName'];?>, 'col-md-<?= $div_width;?>') }}
                        <?php if($index % 12 == 0):?>
                        </div>
                        <div class="row">
                        <?php endif;?>                        
                    <?php endif; ?>
                <?php endforeach; ?>
            <!--end::Item-->
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ path('<?= $route_name;?>_index') }}" class="btn btn-light-dark font-weight-bold">Volver al listado</a>
        </div>
        
	</div>


{% endblock %}

