<?php

/**
 * CubeSummation class.
 * CubeSummation is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class CubeSummation extends CFormModel
{
	public $T;
	public $N;
	public $M;
	public $W;
	public $textArea;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('textArea', 'required'),
			array('textArea', 'InputFormat'),
			array('T', 'numerical','integerOnly'=>true,'min'=>1,'max'=>50),
			array('N', 'numerical','integerOnly'=>true,'min'=>1,'max'=>100),
			array('M', 'numerical','integerOnly'=>true,'min'=>1,'max'=>1000),
			array('W', 'numerical','integerOnly'=>true),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'T'=>'TestCases',
			'N'=>'Matrix',
			'M'=>'Number of operations',
			'W'=>'W',
			'textArea'=>'Ingrese datos',
		);
	}

	/*
	*Input Format
	*The first line contains an integer T, the number of test-cases. T testcases follow.
	*For each test case, the first line will contain two integers N and M separated by a single space.
	*N defines the N * N * N matrix.
	*M defines the number of operations.
	*The next M lines will contain either 
	*/
	public function InputFormat($attribute, $params)
	{
		$rappi = array();
		$nCasos=0;
		$datos=explode("\n", trim($this->$attribute));
		$datos=array_filter($datos);
		for ($i=0; $i < count($datos); $i++) {
			if ($i==0) {
				$this->T=$datos[$i];
				$rappi=$this->numeroCasos($this->T,$rappi);
			}
			if($i!=0 && is_numeric(substr($datos[$i], 0, 1))){
				$nCasos++;
				$matrixOperations=explode(" ", $datos[$i]);
				$rappi=$this->matrix($matrixOperations[0],$rappi,$nCasos,$matrixOperations[1]);
				$i++;
			}
			if ($nCasos>0) {
				for ($j=0; $j <$rappi['caso'.$nCasos]['M']['COperations'] ; $j++) { 
					$rappi=$this->operations($datos[$i],$rappi,$nCasos,$j);
					$i++;
				}
				$i--;
			}
		}
		if (empty($this->$attribute)) {
			$this->addError($attribute,'error');
		}
	}

	/*
	*numero de casos
	*/
	public function numeroCasos($casos,$rappi)
	{
		for ($i=1; $i <= $casos; $i++) { 
			$rappi['caso'.$i]=array(
				'N'=>array('CMatrix'=>0,'matrix'=>array()),
				'M'=>array('COperations'=>0,'operations'=>array())
				);
		}
		return $rappi;
	}

	/*
	*matrix
	*/
	public function matrix($matrix,$rappi,$nCasos,$COperations)
	{
		$AMatrix=array();
		for ($i=1; $i <= $matrix; $i++) { 
			$AMatrix[$i]=array('cubo'=>$i.' '.$i.' '.$i, 'W'=>0);
		}
		$rappi['caso'.$nCasos]=array(
			'N'=>array('CMatrix'=>$matrix,'matrix'=>$AMatrix),
			'M'=>array('COperations'=>$COperations,'operations'=>array())
		);
		return $rappi;
	}

	/*
	*operations
	*/
	public function operations($operations,$rappi,$nCasos,$j)
	{
		$j=$j+1;
		$rappi=$this->updateQuery($operations,$rappi,$nCasos,$j);
		return $rappi;
	}

	/*
	*updateQuery
	*/
	public function updateQuery($operations,$rappi,$nCasos,$j)
	{
		$AOperations=explode(" ", $operations);
		if ($AOperations[0]=='UPDATE') {
			$rappi['caso'.$nCasos]['N']['matrix'][$AOperations[1]]['W']=$AOperations[4];
		} else {
			$desde=$AOperations[1];
			$hasta=$AOperations[4];
			$res=0;
			for ($i=$desde; $i <= $hasta; $i++) { 
				$res+=$rappi['caso'.$nCasos]['N']['matrix'][$i]['W'];
			}
			Yii::app()->session['res'].=$res."<br>";
		}
		$rappi['caso'.$nCasos]['M']['operations'][$j]=$operations;
		return $rappi;
	}
}