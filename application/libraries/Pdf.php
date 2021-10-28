<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
 */

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

// class Pdf
// {
//     function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
//         $dompdf = new Dompdf\DOMPDF();
//         $dompdf->load_html($html);
//         $dompdf->set_paper($paper, $orientation);
//         $dompdf->render();
//         if($download)
//             $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
//         else
//             $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
//     }
// }
class Pdf extends DOMPDF
{
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function ci()
	{
		return get_instance();
	}

	/**
	 * Load a CodeIgniter view into domPDF
	 *
	 * @access	public
	 * @param	string	$view The view to load
	 * @param	array	$data The view data
	 * @return	void
	 */
	public function load_view($view, $data = array())
	{
		$html = $this->ci()->load->view($view, $data, TRUE);

		$this->load_html($html);
	}

	// function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
	function createPDF($html, $filename = '', $download = TRUE, $paper, $orientation)
	{
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		//$domdpf -> setPaper('A4','Landscape');
		// $dompdf->set_paper($paper, 'Landscape');
		$dompdf->set_paper($paper, $orientation);
		$dompdf->render();
		if ($download)
			$dompdf->stream($filename . '.pdf', array('Attachment' => 1));
		else
			$dompdf->stream($filename . '.pdf', array('Attachment' => 0));
	}
}
