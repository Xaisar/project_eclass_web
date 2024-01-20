 <div class="row">
     <div class="col-xl-3 col-md-6">
         <!-- card -->
         <div class="card card-h-100">
             <!-- card body -->
             <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-6">
                         <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Siswa</span>
                         <h4 class="mb-3">
                             <span class="counter-value"
                                 data-target="{{ $studentCount }}">{{ $studentCount }}</span>
                         </h4>
                     </div>
                 </div>
                 <div class="text-nowrap">
                     <span class="badge bg-soft-success text-success">{{ $studentCountActive }} Siswa Aktif</span>
                     <span class="badge bg-soft-danger text-danger">{{ $studentCountInactive }} Siswa Tidak
                         Aktif</span>
                 </div>
             </div><!-- end card body -->
         </div><!-- end card -->
     </div><!-- end col -->

     <div class="col-xl-3 col-md-6">
         <!-- card -->
         <div class="card card-h-100">
             <!-- card body -->
             <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-6">
                         <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Guru</span>
                         <h4 class="mb-3">
                             <span class="counter-value"
                                 data-target="{{ $teacherCount }}">{{ $teacherCount }}</span>
                         </h4>
                     </div>
                 </div>
                 <div class="text-nowrap">
                     <span class="badge bg-soft-success text-success">{{ $teacherCountActive }} Guru Aktif</span>
                     <span class="badge bg-soft-danger text-danger">{{ $teacherCountInactive }} Guru Tidak
                         Aktif</span>
                 </div>
             </div><!-- end card body -->
         </div><!-- end card -->
     </div><!-- end col-->

     <div class="col-xl-3 col-md-6">
         <!-- card -->
         <div class="card card-h-100">
             <!-- card body -->
             <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-6">
                         <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Kelas</span>
                         <h4 class="mb-3">
                             <span class="counter-value"
                                 data-target="{{ $classGroupCount }}">{{ $classGroupCount }}</span>
                         </h4>
                     </div>
                 </div>
                 <div class="text-nowrap">
                     <span class="badge bg-soft-success text-success">{{ $classGroupCountActive }} Kelas Aktif</span>
                     <span class="badge bg-soft-danger text-danger">{{ $classGroupCountInactive }} Kelas Tidak
                         Aktif</span>
                 </div>
             </div><!-- end card body -->
         </div><!-- end card -->
     </div><!-- end col -->

     <div class="col-xl-3 col-md-6">
         <!-- card -->
         <div class="card card-h-100">
             <!-- card body -->
             <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-6">
                         <span class="text-muted mb-3 lh-1 d-block text-truncate">Jumlah Jurusan</span>
                         <h4 class="mb-3">
                             <span class="counter-value" data-target="{{ $majorCount }}">{{ $majorCount }}</span>
                         </h4>
                     </div>
                 </div>
                 <div class="text-nowrap">
                     <span class="badge bg-soft-success text-success">{{ $majorCountActive }} Jurusan Aktif</span>
                     <span class="badge bg-soft-danger text-danger">{{ $majorCountInactive }} Jurusan Tidak
                         Aktif</span>
                 </div>
             </div><!-- end card body -->
         </div><!-- end card -->
     </div><!-- end col -->
 </div><!-- end row-->

 <div class="row">
     <div class="col-xl-5">
         <!-- card -->
         <div class="card card-h-100">
             <!-- card body -->
             <div class="card-body">
                 <div class="d-flex flex-wrap align-items-center mb-4">
                     <h5 class="card-title me-2">Siswa Berdasarkan Jenis Kelamin</h5>
                 </div>

                 <div class="row align-items-center">
                     <div class="col-sm">
                         <div id="student-by-gender" data-colors='["#777aca", "#5156be", "#a8aada"]'
                             class="apex-charts"></div>
                     </div>
                     <div class="col-sm align-self-center">
                         <div class="mt-4 mt-sm-0">
                             <div>
                                 <p class="mb-2"><i
                                         class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i>
                                     Laki-Laki
                                 </p>
                                 <h6 id="male-label"></h6>
                             </div>

                             <div class="mt-4 pt-2">
                                 <p class="mb-2"><i
                                         class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                     Perempuan</p>
                                 <h6 id="female-label"></h6>
                             </div>

                             <div class="mt-4 pt-2">
                                 <p class="mb-2"><i
                                         class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Lainnya
                                 </p>
                                 <h6 id="other-label"></h6>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- end card -->
     </div>
     <!-- end col -->
     <div class="col-xl-7">
         <div class="row">
             <div class="col-xl-12">
                 <!-- card -->
                 <div class="card card-h-100">
                     <!-- card body -->
                     <div class="card-body">
                         <div class="d-flex flex-wrap align-items-center mb-4">
                             <h5 class="card-title me-2">Siswa Berdasarkan Jurusan</h5>
                         </div>

                         <div class="row align-items-center">
                             <div class="col-sm">
                                 <div id="student-by-major" data-colors='["#5156be", "#34c38f"]' class="apex-charts">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- end col -->
         </div>
         <!-- end row -->
     </div>
     <!-- end col -->
 </div> <!-- end row-->
