<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class <classname> extends stdClass implements DataInterface
{
    <public> 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                <datamembers>
            }
            else
            {
                foreach ($datos as $k => $v)
                {
                    $this->$k = $v;
                }
            }
        }
        catch (\Exception $e)
        {}
    }
    public function sql()
    {
        return "<create>";
    }
}
