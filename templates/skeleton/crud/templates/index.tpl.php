<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>
{% extends 'base.html.twig' %}

{% block stylesheets %}

    {{ parent() }}
    <link href="{{ asset(plugins_path ~ 'custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>

{% endblock %}

{% block body %}
    <!--begin::Card-->
	<div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
				<span class="card-icon"><i class="flaticon2-layers text-primary"></i></span>
				<h3 class="card-label">Listado de <?= $entity_twig_var_plural ?></h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Dropdown-->
				<div class="dropdown dropdown-inline mr-2">
					<!--
					<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="la la-download"></i> Exportar 
					</button>
					-->
					<!--begin::Dropdown Menu-->
					<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
						<ul class="nav flex-column nav-hover">
							<li class="nav-header font-weight-bolder text-uppercase  text-primary pb-2">
								Seleccione una opci&oacute;n:
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon la la-print"></i>
									<span class="nav-text">Imprimir</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon la la-copy"></i>
									<span class="nav-text">Copiar</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon la la-file-excel-o"></i>
									<span class="nav-text">Excel</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon la la-file-pdf-o"></i>
									<span class="nav-text">PDF</span>
								</a>
							</li>
						</ul>
					</div>
					<!--end::Dropdown Menu-->
				</div>
				<!--end::Dropdown-->

                {% if is_granted('ROLE_<?= strtoupper($entity_twig_var_singular) ?>_CREATE') %}
				<!--begin::Button-->
				<a href="{{ path('<?= $route_name;?>_new') }}" class="btn btn-primary font-weight-bolder">
					<i class="la la-plus"></i>
					Agregar
				</a>
				<!--end::Button-->
                {% endif %}
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-bordered table-hover table-checkable" id="table-<?= $route_name;?>">
				<thead>
					<tr>
						<th class="not-in-filter">ID</th>
                        <?php $search  = array('_', 'ñ', 'cion');
                            $replace = array(' ', '&ntilde;', 'ci&oacute;n');?>
                        <?php foreach ($entity_fields as $form_field => $typeOptions): ?>
                            <?php if (!in_array($form_field, $excludedVariables)): ?>
                                <?php switch($typeOptions['type']){
                                    case 'integer': 
                                    case 'float': 
                                    case 'decimal': $data_type = 'number';break;
                                    case 'entity': 
                                    case 'boolean': $data_type = 'select';break;
                                    case 'date': $data_type = 'date';break;
                                    case 'datetime': $data_type = 'datetime';break;
                                    default: $data_type = 'string';
                                }
                                ?>
                            <th data-type="<?= $data_type;?>" <?= $typeOptions['type'] == 'boolean' ? 'data-select="Todos:Todos;0:No;1:S&iacute"' : ''?>><?= ucfirst(str_replace($search, $replace, $form_field));?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <th data-type="search">Acciones</th>
					</tr>
				</thead>
			</table>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
{% endblock %}

{% block javascripts %}

    {{ parent() }}

    <script type="text/javascript" src="{{ asset(plugins_path ~ 'custom/datatables/datatables.bundle.js') }}"></script>

    <script src="{{ asset(__PREFIX_JAVASCRIPT__ ~ 'config/config-datatables.js') }}" ></script>
    <script src="{{ asset(__PREFIX_JAVASCRIPT__ ~ 'app/<?= $js_path;?>/index.js') }}" ></script>

{% endblock %}

