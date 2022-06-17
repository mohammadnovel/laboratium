<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Invoice </title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="4">
						<table>
							<tr>
								<td class="title">
									{{-- <img src="{{asset('images/logo.png')}}" style="width: 100%; max-width: 300px" /> --}}
                                    <p>La<span class="text-purple-600">bs.</span></p>
								</td>

								<td>
									Laporan Lab<br />
									dari tanggal : {{$report->from_date}}<br />
									Sampai : {{$report->to_date}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td>
									RS. Bhakti Medicare.<br />
									Jl. Siliwangi No.186B, Cicurug, <br> 
									Kec. Cicurug, Kabupaten Sukabumi, <br> 
									Jawa Barat 43359.
								</td>

								{{-- <td>
									Acme Corp.<br />
									John Doe<br />
									john@example.com
								</td> --}}
							</tr>
						</table>
					</td>
				</tr>
				<br>
				<tr>
					<td colspan="4">SDM Laboratorium</td>
				</tr>
				<tr>
					<td colspan="4">
						{!! $general->description !!}
					</td>
				</tr>
				<br><br><br><br>

				<tr >
					<td colspan="2"><b>Pelayanan Lab (Service)	</b></td>
                    
					<td colspan="2"></td>
				</tr>

				<tr class="heading">
					<td colspan="2">Nama Pelayanan</td>
					<td colspan="2">Jumlah</td>
				</tr>

				@foreach ($report->report_service as $lab_service)
				{{-- {{$lab_service}} --}}
				<tr class="item">
					<td colspan="2">{{$lab_service->service->name}}</td>
					<td colspan="2">{{$lab_service['qty']}}</td>
				</tr>
				@endforeach

				<tr class="total">
					<td colspan="3"></td>

					<td style="background-color: gold;color:#333">Total: {{$report->report_service->sum('qty')}}</td>
				</tr>
				<br><br><br><br>
				 {{-- parameter --}}
				<tr >
					<td colspan="2"><b>Pelayanan Lab Berdasarkan Parameter</b>	</td>
                    
					<td colspan="2"></td>
				</tr>

				<tr class="heading">
					<td colspan="2">Nama Pelayanan</td>
					<td colspan="2">Jumlah</td>
				</tr>

				@foreach ($report->report_parameter as $param)
				<tr class="item">
					<td colspan="2">{{$param->parameter->name}}</td>
					<td colspan="2">{{$param['qty']}}</td>
				</tr>
				@endforeach

				<tr class="total">
					<td colspan="3"></td>

					<td style="background-color: gold;color:#333">Total: {{$report->report_parameter->sum('qty')}}</td>
				</tr>
				<br><br><br><br><br><br>

				{{-- compotition --}}
				<tr >
					<td colspan="2"><b>Komposisi Pasien</b></td>
                    
					<td colspan="2"></td>
				</tr>

				<tr class="heading">
					<td colspan="2">Komposisi Pasien</td>
					<td colspan="2">Jumlah</td>
				</tr>

				@foreach ($report->report_compotition as $compotition)
				<tr class="item">
					<td colspan="2">{{$compotition->compotition->name}}</td>
					<td colspan="2">{{$compotition['qty']}}</td>
				</tr>
				@endforeach

				<tr class="total">
					<td colspan="3"></td>

					<td style="background-color: gold;color:#333">Total: {{$report->report_compotition->sum('qty')}}</td>
				</tr>
				<br><br><br><br>

				{{-- indicator mutu --}}
				<tr >
					<td colspan="2"><b>Indikator Mutu Lab</b></td>
                    
					<td colspan="2"></td>
				</tr>

				<tr class="heading">
					<td>No.</td>
					<td style="text-align: left">Jenis Pemeriksaan</td>
					<td style="text-align: right" colspan="2">Waktu</td>
				</tr>

				@foreach ($indicator_mutu as $imutu)
				<tr class="item">
					<td>{{ $loop->index+1}}.</td>
					<td style="text-align: left">{{$imutu->name}}</td>
					<td style="text-align: right" colspan="2">{{$imutu->timed}}</td>
				</tr>
				@endforeach
				<br><br>

				{{-- patient indification --}}
				<tr >
					<td colspan="2"><b>Identifikasi Pasien</b></td>
                    
					<td colspan="2"></td>
				</tr>

				<tr class="heading">
					<td colspan="2">Identifikasi Pasien</td>
					<td colspan="2">Jumlah</td>
				</tr>

				@foreach ($report->report_patient_indification as $pi)
				<tr class="item">
					<td colspan="2">{{$pi->patient_indification->name}}</td>
					<td colspan="2">{{$pi['qty']}}</td>
				</tr>
				@endforeach

				<tr class="total">
					<td colspan="3"></td>

					<td style="background-color: gold;color:#333">Total: {{$report->report_patient_indification->sum('qty')}}</td>
				</tr>
			</table>
		</div>
	</body>
</html>