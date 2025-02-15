<?php $__env->startSection('content'); ?>
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                <img src="<?php echo e(asset('assets/img/sample/avatar/avatar1.jpg')); ?>" alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
                <h2 id="user-name">Adam Abdi Al A'la</h2>
                <span id="user-role">Head of IT</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">


                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <?php if($presensiHariIni != null): ?>
                                        <?php
                                            $path = Storage::url('uploads/absensi/' . $presensiHariIni->foto_in);

                                        ?>
                                        <img src="<?php echo e(url($path)); ?>" alt="" class="imaged w48">
                                    <?php else: ?>
                                        <ion-icon name="camera"></ion-icon>
                                    <?php endif; ?>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span><?php echo e($presensiHariIni != null ? $presensiHariIni->jam_in : 'Belum Absen'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <?php if($presensiHariIni != null && $presensiHariIni->jam_out != null): ?>
                                        <?php
                                            $path = Storage::url('uploads/absensi/' . $presensiHariIni->foto_out);

                                        ?>
                                        <img src="<?php echo e(url($path)); ?>" alt="" class="imaged w48 ">
                                    <?php else: ?>
                                        <ion-icon name="camera"></ion-icon>
                                    <?php endif; ?>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span><?php echo e($presensiHariIni != null && $presensiHariIni->jam_out != null ? $presensiHariIni->jam_out : 'Belum Absen'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="rekappresensi">
            <h3>Rekap Presensi Bulan <?php echo e($namaBulan[$bulanKini]); ?> Tahun <?php echo e($tahunKini); ?></h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">10</span>
                            <ion-icon name="accessibility-outline" style="font-size:1.6rem;"
                                class="text-primary mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem, font-weight:500 ">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">

                            <ion-icon name="newspaper-outline" style="font-size:1.6rem;"
                                class="text-success mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">

                            <ion-icon name="medkit-outline" style="font-size:1.6rem;"
                                class="text-warning mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">

                            <ion-icon name="alarm-outline" style="font-size:1.6rem;"
                                class="text-danger mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">

                        
                        <?php $__currentLoopData = $historyBulanIni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            

                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div><?php echo e(date('d-m-Y', strtotime($item->tgl_presensi))); ?></div>
                                        <span class="badge badge-success"><?php echo e($item->jam_in); ?></span>
                                        <span
                                            class="badge badge-danger"><?php echo e($presensiHariIni != null && $item->jam_out != null ? $item->jam_out : 'Belum Absen'); ?></span>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item">
                                <img src="<?php echo e(asset('assets/img/sample/avatar/avatar1.jpg')); ?>" alt="image"
                                    class="image">
                                <div class="in">
                                    <div>Edward Lindgren</div>
                                    <span class="text-muted">Designer</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Emelda Scandroot</div>
                                    <span class="badge badge-primary">3</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Henry Bove</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Henry Bove</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Henry Bove</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.presensi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Frengki\Learn\php\Laravel\presensigps\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>