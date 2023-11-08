<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class alert
{
	function set($icon, $title, $text, $url = null)
	{
		$ci = get_instance();
		$data = [
			'icon' => $icon,
			'title' => $title,
			'text' => $text,
			'url' => $url
		];

		$ci->session->set_flashdata('iconFlash', $data['icon']);
		$ci->session->set_flashdata('titleFlash', $data['title']);
		$ci->session->set_flashdata('textFlash', $data['text']);
		$ci->session->set_flashdata('urlFlash', $data['url']);
	}

	function get($value = null)
	{
		/*
		<div id="flash" data-icon="<?= $this->session->flashdata('iconFlash'); ?>" data-title="<?= $this->session->flashdata('titleFlash'); ?>" data-text="<?= $this->session->flashdata('textFlash'); ?>" data-url="<?= $this->session->flashdata('urlFlash'); ?>"></div>

		*/

		$ci = get_instance();

		// return $ci->session->flashdata($value);
		return '<div id="flash" data-icon="' . $ci->session->flashdata('iconFlash') . '" data-title="' . $ci->session->flashdata('titleFlash') . '" data-text="' . $ci->session->flashdata('textFlash') . '" data-url="' . $ci->session->flashdata('urlFlash') . '"></div>';
	}

	function init($set)
	{

		// ini javascript buat popup pidah link kayak pake target
		// window.open('https://www.w3schools.com');


		// $dataLink = '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
		$dataLink = '<script src="' . base_url('assets/sweetalert2/sweetalert2.all.min.js') . '"></script>';


		$data_jquery = "
			<script>
				const iconFlash = $('#flash').data('icon');
				const titleFlash = $('#flash').data('title');
				const textFlash = $('#flash').data('text');
				const urlFlash = $('#flash').data('url');
				const baseurl = $('#baseurl').val();


				if (iconFlash && urlFlash) {
					Swal.fire({
						icon: iconFlash,
						title: titleFlash,
						text: textFlash,
						footer: '<a href>Alert Pake Link</a>'
					}).then((result) => {
						if (result.value) {
							window.location.href = urlFlash;
						}
					})
				} else if (iconFlash) {
					Swal.fire({
						icon: iconFlash,
						title: titleFlash,
						text: textFlash
					})
				}

				// footer: '<a href>Alert Biasa?</a>'

				$('.del-tombol').on('click', function(e){
					const ket = $(this).data('ket');
					const href = ($(this).data('href')) ? $(this).data('href') : $(this).attr('href');
					Swal.fire({
					  title: 'Are you sure?',
					  text: ket,
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					    window.location.href = href;
					   }
					})
				   e.preventDefault();
				});
			</script>

		";

		$data_vanilla = "
			<script>

				var btns = document.getElementsByClassName('del-tombol');
				for (var i = 0; i < btns.length; i++) {
					btns[i].addEventListener('click', function(e) {
						const ket = this.getAttribute('data-ket');
						const href = (this.getAttribute('data-href')) ? this.getAttribute('data-href') : this.getAttribute('href');
						Swal.fire({
						  title: 'Are you sure?',
						  text: ket,
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
						  if (result.value) {
						    window.location.href = href;
						   }
						})
					   e.preventDefault();
					})
				}


				const iconFlash = document.getElementById('flash').getAttribute('data-icon');
				const titleFlash = document.getElementById('flash').getAttribute('data-title');
				const textFlash = document.getElementById('flash').getAttribute('data-text');
				const urlFlash = document.getElementById('flash').getAttribute('data-url');


				if (iconFlash && urlFlash) {
					Swal.fire({
						icon: iconFlash,
						title: titleFlash,
						text: textFlash,
						footer: '<a href>Alert Pake Link</a>'
					}).then((result) => {
						if (result.value) {
							window.location.href = urlFlash;
						}
					})
				} else if (iconFlash) {
					Swal.fire({
						icon: iconFlash,
						title: titleFlash,
						text: textFlash
					})
				}

				
			</script>

		";

		if ($set == "vanilla") {
			echo $dataLink . $data_vanilla;
		} else {
			// echo '<div id="flash" data-icon="" data-title="" data-text="" data-url=""></div>';
			echo  $dataLink . $data_jquery;
		}
	}
}
