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
                                <span class="card-label font-weight-bolder text-dark">Cari CPD</span>
                            </h3>
                            <div id="form_cari_noreg" class="form">
                                <div class="form-group mb-5">
                                <label>Nomor Registrasi : </label>
                                    <input type="text" class="form-control border-1" name="no_reg" placeholder="Nomor Registrasi">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="reset" class="btn btn-primary font-weight-bold">Cari</button>
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
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Identitas CPD</span>
                            <!--<span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new
                                members</span>-->
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-3 pb-0">
                        <!--begin::Table-->
                        
                        <!--end::Table-->
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