<?php

namespace App\Forms;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;

class Descuentos
{
    public static function form($arguments = [])
    {
        $html = "
        <div id='DescuentoPanel'>
            <form id='descuentoForm' aria-autocomplete='none'>
                <div class='row gx-5 justify-content-center'>
                    <div class='col-lg-4 col-md-6'>
                        <div class='form-floating mb-3 justify-content-center'>
                            <div class='form-check form-check-inline form-switch'>
                                <input class='form-check-input' type='radio' name='DesTipo' id='DesTipo0' value='0' />
                                <label class='form-check-label' for='DesTipo0'>Descuento</label>
                            </div>
                            <div class='form-check form-check-inline form-switch'>
                                <input class='form-check-input' type='radio' name='DesTipo' id='DesTipo1' value='1' />
                                <label class='form-check-label' for='DesTipo1'>Promoción</label>
                            </div>
                        </div>
                        <br>
                        <div class='form-floating mb-3 justify-content-center'>
                            <div class='form-check form-check-inline form-switch'>
                                <input class='form-check-input' type='radio' name='DesObjetivo' id='DesTipo2' value='Producto' />
                                <label class='form-check-label' for='DesTipo2'>Producto</label>
                            </div>
                            <div class='form-check form-check-inline form-switch'>
                                <input class='form-check-input' type='radio' name='DesObjetivo' id='DesTipo3' value='Categoria' />
                                <label class='form-check-label' for='DesTipo3'>Categoria</label>
                            </div>
                            <div class='form-check form-check-inline form-switch'>
                                <input class='form-check-input' type='radio' name='DesObjetivo' id='DesTipo4' value='SubCat'>
                                <label class='form-check-label' for='DesTipo4'>Sub Categoria</label>
                            </div>
                        </div>
                        <br>
                        <input id='DesID' name='DesID' type='hidden' />
                        <input id='CSRF' type='hidden' value='".CurrentUser::getCsrf()."' />

                        <div class='input-group form-floating mb-3 producto'>
                            <input class='form-control' type='text' name='DesProductos' id='producto' />
                            <label for='producto'>Producto</label>
                            <span class='input-group-text'>
                                <a class='btn btn-primary box' id='buscarProducto' href='Listas-Productos/Descuento'><i class='fa fa-search'></i>
                                </a>
                            </span>
                        </div>
                        <div class='input-group form-floating mb-3 categoria'>
                            <input class='form-control' type='text' name='DesCategorias' id='categoria' />
                            <label for='categoria'>Categoria</label>
                            <span class='input-group-text'>
                                <a class='btn btn-primary box' id='buscarCategoria' href='Listas-Categorias/Descuento'><i class='fa fa-search'></i>
                                </a>
                            </span>
                        </div>
                        <div class='input-group form-floating mb-3 subcat'>
                            <input class='form-control' type='text' name='DesSubCat' id='subcat' />
                            <label for='subcat'>Sub Categoria</label>
                            <span class='input-group-text'>
                                <a class='btn btn-primary box' id='buscarCategoria' href='Listas-Sub/Descuento'><i class='fa fa-search'></i>
                                </a>
                            </span>
                        </div>
                        <div class='form-floating mb-3'>
                            <input class='form-control' id='DesInicia' name='DesInicia' type='date' required />
                            <label for='DesInicia'> Dia Inicial</label>
                        </div>
                        <div class='form-floating mb-3'>
                            <input class='form-control' id='DesTermina' name='DesTermina' type='date' required />
                            <label for='DesTermina'> Dia Final</label>
                        </div>
                        <div class='form-floating mb-3'>
                            <input class='form-control' id='DesNombre' name='DesNombre' type='text' required />
                            <label for='DesNombre'> Nombre o Razón</label>
                        </div>
                        <div class='form-floating mb-3'>
                            <textarea class='form-control' id='DesDescripcion' rows='5' style='height: auto;' name='DesDescripcion'></textarea>
                            <label for='DesDescripcion'> Descripcion</label>
                        </div>
                        <div class='form-floating mb-3 descuento'>
                            <input class='form-control' id='DesPorcentaje' name='DesPorcentaje' type='number' step='0.01' value='0.00' />
                            <label for='DesPrecio'> Porcentaje Descuento</label>
                        </div>
                        <div class='form-floating mb-3  promosion'>
                            <input class='form-control' id='DesPrecio' name='DesPrecio' type='number' step='0.01' value='0.00' />
                            <label for='DesPrecio'> Precio Promoción</label>
                        </div>
                        <div class='form-floating mb-3 promosion'>
                            <input class='form-control' id='DesCondicion' name='DesCondicion' type='text' />
                            <label for='DesCondicion'> Condicion Promoción</label>
                        </div>

                        <!-- Submit Button-->
                        <div class='button-group text-center'>
                            <button class='btn btn-primary archivar' id='submitButtonPromosion' type='submit'>Archivar</button>                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
        ";
        return $html;        
    }
}