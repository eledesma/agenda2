<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of agenda_inicio
 *
 * @author mago
 */
class agenda_inicio extends fs_controller

{
   public $editar;
  public $listado;

  public function __construct()
  {
     parent::__construct(__CLASS__,'portada','agenda');
  }

  protected function private_core()

  {

    $this->editar=FALSE;
    if (isset($_POST['id']))
      {
      $this->editar=  $this->db->select("SELECT * FROM agenda WHERE id ='".$_POST['id']."';");
      if ($this->editar)
       {
     $fecha = Date('Y-m-d', strtotime($_POST['fecha']));
     $fecha.=' '.$_POST['hora'];

     $completado=0;
     if(isset($_POST['completado']))
     {
       $completado=1;
     }


     $sql= "UPDATE agenda SET fecha = '".$fecha."',usuario = '".$_POST['usuario']."', tarea = '".$_POST['tarea']."',
      completado = '".$completado."' WHERE id = '".$_POST['id']."';";


     if($this->db->exec($sql))
     {
       $this->new_message('Se ha Modificado correctamente ....OK....');
       $this->editar=$this->db->select("select * from agenda WHERE id='".$_POST['id']."';");
     }
     else

       $this->new_error_msg('error al modificar datos');
    }
      }
    else if (isset($_POST['fecha']))

    {
     $fecha=Date('Y-m-d', strtotime($_POST['fecha']));
     $fecha.=' '.$_POST['hora'];

     $sql="INSERT INTO agenda (fecha,usuario,tarea)
       VALUES ('".$fecha."','".$_POST['usuario']."','".$_POST['tarea']."');";


     if($this->db->exec($sql))
     {
       $this->new_message('Se ha guardado correctamente ....OK....');
     }
     else

       $this->new_error_msg('error al ingresar datos');
    }
 else if (isset($_GET['id']))
     {
   $this->editar=$this->db->select("select * from agenda WHERE id= '".$_GET['id']."';");
     }

     else if (isset ($_GET['delete']))
       {
     if($this->db->exec("DELETE * FROM agenda WHERE id = '".$_GET['delete']."';"))
     {
       $this->new_message('eliminado correctamente el evento');
     }
 else {
       $this->new_message('error al eliminar el evento');
     }
       }


    $this->listado=  $this->db->select("select * from agenda ORDER BY fecha DESC;");


 }

 public function separa_fecha()
         {
          $data=explode(' ', $this->editar[0]['fecha']);
          return Date('Y-m-d',strtotime($data[0]));

         }
   public function separa_hora()
         {
          $data=explode(' ',$this->editar[0]['fecha']);
          return $data[1];

         }

     }


?>
