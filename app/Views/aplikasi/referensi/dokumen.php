<?= $this->extend('aplikasi/layout/template') ?>

<?= $this->Section('content') ?>
<!--begin::Content-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <!--begin::Top-->

                <!--end::Top-->
                <!--begin::Separator-->
                <!--<div class="separator separator-solid my-7"></div>-->
                <!--end::Separator-->
                <!--begin::Bottom-->
                <div class="d-flex align-items-center flex-wrap">
                    <div class="form">
                        <div class="card-body">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Dokumen/Berkas</span>
                            </h3>
                            <h6>
                                <span class="card-label font-weight-bolder text-mute">Jenis Dokumen/Berkas kelengkapan PPDB 2024</span>
                            </h6>
                                <!--begin::Form-->
                                <form>
                                    <div class="card-body">
                                        <!-- alert import success -->
										<?php if (session()->getFlashdata('pesan')) : ?>
											<div class="alert alert-custom alert-success fade show mb-2" role="alert">
												<div class="alert-icon">
													<i class="flaticon-warning"></i>
												</div>
												<div class="alert-text"><?= session()->getFlashdata('pesan'); ?></div>
												<div class="alert-close">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">
															<i class="ki ki-close"></i>
														</span>
													</button>
												</div>
											</div>

										<?php endif; ?>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label text-lg-right">Upload File:</label>
                                            <button type="button" class="btn btn-light-primary font-weight-bolder" data-toggle="modal" data-target="#uploadExcelModal" aria-haspopup="true" aria-expanded="false">
                                                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Outgoing-box.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M22,17 L22,21 C22,22.1045695 21.1045695,23 20,23 L4,23 C2.8954305,23 2,22.1045695 2,21 L2,17 L6.27924078,17 L6.82339262,18.6324555 C7.09562072,19.4491398 7.8598984,20 8.72075922,20 L15.381966,20 C16.1395101,20 16.8320364,19.5719952 17.1708204,18.8944272 L18.118034,17 L22,17 Z" fill="#000000"/>
                                                            <path d="M2.5625,15 L5.92654389,9.01947752 C6.2807805,8.38972356 6.94714834,8 7.66969497,8 L16.330305,8 C17.0528517,8 17.7192195,8.38972356 18.0734561,9.01947752 L21.4375,15 L18.118034,15 C17.3604899,15 16.6679636,15.4280048 16.3291796,16.1055728 L15.381966,18 L8.72075922,18 L8.17660738,16.3675445 C7.90437928,15.5508602 7.1401016,15 6.27924078,15 L2.5625,15 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>Import</button>
                                        </div>
                                        <span class="text-muted pt-2 font-size-sm d-block">Silakan klik tombol Import di atas untuk mengunggah referensi dokumen.</span>
                                        <!-- Modal-->
                                        <div class="modal fade" id="uploadExcelModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Form Unggah Jenis Dokumen/Berkas PPDB</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i aria-hidden="true" class="ki ki-close"></i>
                                                        </button>
                                                    </div>
                                                    <!-- modal-body -->
                                                    <div class="modal-body">
                                                        <h5>Template.</h5>
                                                        <p>
                                                            Klik <a href="#" title="File Template" data-toggle="tooltip">unduh</a> untuk mengambil file template.
                                                        </p>
                                                        <hr>
                                                        <h8>Silakan klik tombol "Browse" untuk mengunggah file excel</h8>
                                                        <p>
                                                            <form method="post" action="unggahdokumen/import" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label>File Excel</label>
                                                                    <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" /></p>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button class="btn btn-primary" type="submit">Unggah</button>
                                                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </form>
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                                    <!--end::Form-->
                                <!--end::Card-->
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
                <!--end::Bottom-->
            </div>
        </div>
        <!--end::Card-->

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <!--begin::Bottom-->
                <!--begin::Advance Table Widget 2-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Dokumen PPDB 2024
                                <span class="text-muted pt-2 font-size-sm d-block">Daftar Dokumen Kelengkapan PPDB 2024</span></h3>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <!--begin: Search Form-->
                            <!--begin::Search Form-->
                            <div class="mb-7">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Search Form-->
                            <!--end: Search Form-->
                            <!--begin: Datatable-->
                            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                            <!--end: Datatable-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 2-->
                <!--end::Bottom-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Content-->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<!-- <script src="assets-app/js/pages/crud/ktdatatable/base/data-local.js?v=7.0.4"></script> -->
<script src="assets-app/js/pages/crud/ktdatatable/base/dokumen.js"></script>
<?= $this->endSection() ?>