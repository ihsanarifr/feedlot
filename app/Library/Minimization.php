<?php 
namespace App\library;

use App\Library\SimplexMethod;
use Illuminate\Http\Request;

class Minimization extends SimplexMethod
{
    private $valueArray = array();
    private $num = array();
    private $total_number;

    public function index()
    {
        echo SimplexMethod::is_ok();
        return "Minimization extends SimplexMethod";

    }

    public function get_num()
    {
        return $this->num;
    }

    public function get_total_number()
    {
        return $this->total_number;
    }

    public function optimize(Request $request)
    {
        //solves for the minimization problem
        //get the number of constraints from the hidden form input named numbers and put it into the array named num
        $flag = 0;
        $minRow = 0;
        $i = 0;
        $token=strtok($request->input('numbers'), ',');
        
        while($token)
        {
            $this->num[$i++]=$token;
            $token=strtok(',');
        }

        //$n+1 would be the total number of columns
        $this->total_number = $this->num[0]+$this->num[1];

        //get the values from the form and insert it into the array
        $this->insert_value($request);

        //if the relational operator is <=, negate the entire row - it's like converting <= to >=
        $this->check_operator($request);

        //transpose the matrix because we would be forming the dual problem, we are going to convert the minimization problem to a maximization one
        $simplex = new SimplexMethod;
        $this->valuesArray = $simplex->transposeMatrix($this->valuesArray, $this->num[1], $this->num[0]);

        //after transposing the matrix, negate the last row
        $this->transpose_negate_last_row();
        

        //add the slack variables, the number of slack variables would be the number of unknown variables
        $this->add_slack_variables();

        //add the the coefficients of the objective function to the last column of the array
        $this->add_coefficients_objective($request);

        //display the initial tableau
        $initial_tableau = $this->valuesArray;
        
        #$this->print_dump($initial_tableau);

        return $this->valuesArray;
    }

    private function insert_value($request)
    {
        for($k=1; $k<=$this->num[1]+1; $k++)
        {
            for($j=1; $j<=$this->num[0]; $j++)
            {
                if($k!=$this->num[1]+1)
                    $this->valuesArray[$k-1][$j-1]=floatval($request->input('cons'.$k.'_'.$j.''));
                else
                    $this->valuesArray[$k-1][$j-1]=floatval($request->input('var'.$j.''));
                if($j==$this->num[0])
                {
                    if($k!=$this->num[1]+1)
                        $this->valuesArray[$k-1][$j]=floatval($request->input('answer'.$k.''));
                    else
                        $this->valuesArray[$k-1][$j]=0;
                }
            }
        }
    }

    private function check_operator($request)
    {
        for($k=1; $k<=$this->num[1]; $k++)
        {
            for($j=1; $j<=$this->num[0]; $j++)
            {
                if($request->input('sign'.$k.'')=='lessThan')
                {
                    if($k!=$this->num[1]+1 && $this->valuesArray[$k-1][$j-1]!=0)
                        $this->valuesArray[$k-1][$j-1]*=-1;
                    else
                        $this->valuesArray[$k-1][$j-1]*=1;
                    if($j==$this->num[0])
                    {
                        if($k!=$this->num[1]+1)
                            $this->valuesArray[$k-1][$j]*=-1;
                        else
                            $this->valuesArray[$k-1][$j]=0;
                    }
                }
            }
        }
    }

    private function transpose_negate_last_row()
    {
        for($i=0; $i<$this->num[1]; $i++)
            $this->valuesArray[$this->num[0]][$i] *= -1;
    }

    private function add_slack_variables()
    {
        for($i=1; $i<=$this->num[0]+1; $i++)
        {
            $k=0;
            for($j=$this->num[1]; $j <= $this->total_number; $j++)
            {
                if($k != ($i - 1))
                    $this->valuesArray[$i-1][$j] = 0;
                else if ($i==$this->num[1]+1)
                    $this->valuesArray[$i-1][$j] = 1;
                else
                    $this->valuesArray[$i-1][$j] = 1;
                $k++;
            }
        }
    }

    private function add_coefficients_objective($request)
    {
        for($i=1; $i<=$this->num[0]+1; $i++)
        {
            if(($i-1)!=$this->num[0])
                $this->valuesArray[$i-1][$this->total_number+1]=floatval($request->input('var'.$i.''));
            else
                $this->valuesArray[$i-1][$this->total_number+1]=0;
        }
    }

    private function render_view()
    {
        $this->valuesArray;
    }

    private function print_dump($array)
    {
        echo "<pre>";
        print_r($array);
        die();
    }
}

