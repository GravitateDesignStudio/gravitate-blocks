<?php

/**
 *
 * @author Gravitate
 *
 */
class GRAV_BLOCKS_CSS {

	public $class = array();


	/**
	 * This is the initial setup that connects the Settings and loads the Fields from ACF
	 *
	 * @return void
	 */
	public function __construct()
	{
		//return $this->class;
	}

	public function css()
	{
		return $this;
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public function col($small=12, $med=12, $large=12, $xlarge=12)
	{
		$this->class[] = 'columns';

		if($small && $small < 12)
		{
			$this->class[] = 'col-xs-'.$small.' small-'.$small;
		}

		if($med && $med < 12)
		{
			$this->class[] = 'col-sm-'.$med.' medium-'.$med;
		}

		if($large && $large < 12)
		{
			$this->class[] = 'col-md-'.$large.' large-'.$large;
		}

		if($xlarge && $xlarge < 12)
		{
			$this->class[] = 'col-lg-'.$xlarge.' xlarge-'.$xlarge;
		}

		return $this;
	}

	public function col_offset($small=12, $med=12, $large=12, $xlarge=12)
	{
		if($small && $small < 12)
		{
			$this->class[] = 'col-xs-offset-'.$small.' small-offset-'.$small;
		}

		if($med && $med < 12)
		{
			$this->class[] = 'col-sm-offset-'.$med.' medium-offset-'.$med;
		}

		if($large && $large < 12)
		{
			$this->class[] = 'col-md-offset-'.$large.' large-offset-'.$large;
		}

		if($xlarge && $xlarge < 12)
		{
			$this->class[] = 'col-lg-offset-'.$xlarge.' xlarge-offset-'.$xlarge;
		}

		return $this;
	}

	public function col_push($small=12, $med=12, $large=12, $xlarge=12)
	{
		if($small && $small < 12)
		{
			$this->class[] = 'col-xs-push-'.$small.' small-push-'.$small;
		}

		if($med && $med < 12)
		{
			$this->class[] = 'col-sm-push-'.$med.' medium-push-'.$med;
		}

		if($large && $large < 12)
		{
			$this->class[] = 'col-md-push-'.$large.' large-push-'.$large;
		}

		if($xlarge && $xlarge < 12)
		{
			$this->class[] = 'col-lg-push-'.$xlarge.' xlarge-push-'.$xlarge;
		}

		return $this;
	}

	public function col_pull($small=12, $med=12, $large=12, $xlarge=12)
	{
		if($small && $small < 12)
		{
			$this->class[] = 'col-xs-pull-'.$small.' small-pull-'.$small;
		}

		if($med && $med < 12)
		{
			$this->class[] = 'col-sm-pull-'.$med.' medium-pull-'.$med;
		}

		if($large && $large < 12)
		{
			$this->class[] = 'col-md-pull-'.$large.' large-pull-'.$large;
		}

		if($xlarge && $xlarge < 12)
		{
			$this->class[] = 'col-lg-pull-'.$xlarge.' xlarge-pull-'.$xlarge;
		}

		return $this;
	}

	public function grid($small=1, $med=2, $large=3, $xlarge=4)
	{

		if($small && $small <= 4)
		{
			$this->class[] = 'small-block-grid-'.$small;
		}

		if($med && $med <= 4)
		{
			$this->class[] = 'medium-block-grid-'.$med;
		}

		if($large && $large <= 4)
		{
			$this->class[] = 'large-block-grid-'.$large;
		}

		// if($xlarge && $xlarge <= 4)
		// {
		// 	$this->class[] = 'xlarge-block-grid-'.$xlarge;
		// }

		return $this;
	}


	public function row()
	{
		$this->class[] = 'row';
		return $this;
	}

	public function collapsed()
	{
		$this->class[] = 'collapsed';
		return $this;
	}


	public function col_center($small=true, $medium=null, $large=null, $xlarge=null)
	{
		$sizes = array(
			array('name' => 'small', 'value' => $small),
			array('name' => 'medium', 'value' => $medium),
			array('name' => 'large', 'value' => $large),
			array('name' => 'xlarge', 'value' => $xlarge)
		);

		foreach ($sizes as $key => $size)
		{
			if($size['value'])
			{
				$this->class[] = 'center-block '.$size['name'].'-centered';
			}
		}

		return $this;
	}

	public function col_uncenter($small=true, $medium=null, $large=null, $xlarge=null)
	{
		$sizes = array(
			array('name' => 'small', 'value' => $small),
			array('name' => 'medium', 'value' => $medium),
			array('name' => 'large', 'value' => $large),
			array('name' => 'xlarge', 'value' => $xlarge)
		);

		foreach ($sizes as $key => $size)
		{
			if($size['value'])
			{
				$this->class[] = 'center-block '.$size['name'].'-uncentered';
			}
		}

		return $this;
	}




	public function get()
	{
		return implode(' ', $this->class);
	}




	public function out()
	{
		echo $this->get();
	}
}