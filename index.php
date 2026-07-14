<?php
// ==========================================
// ข้อมูลจำลอง (Mock Data) สำหรับออกแบบหน้าตา
// ==========================================

$teams = [
    1 => [
        'name' => 'Gryffindor United', 'weeks_played' => 3, 'points' => 5,
        'members' => [
            ['name' => 'Harry Potter', 'job' => 'Seeker / Captain'],
            ['name' => 'Ron Weasley', 'job' => 'Keeper'],
            ['name' => 'Hermione Granger', 'job' => 'Tactician']
        ]
    ],
    2 => [
        'name' => 'Slytherin FC', 'weeks_played' => 3, 'points' => 4,
        'members' => [
            ['name' => 'Draco Malfoy', 'job' => 'Seeker'],
            ['name' => 'Blaise Zabini', 'job' => 'Chaser'],
            ['name' => 'Gregory Goyle', 'job' => 'Beater']
        ]
    ],
    3 => [
        'name' => 'Ravenclaw Elite', 'weeks_played' => 3, 'points' => 2,
        'members' => [
            ['name' => 'Luna Lovegood', 'job' => 'Free-thinker'],
            ['name' => 'Cho Chang', 'job' => 'Chaser']
        ]
    ],
    4 => [
        'name' => 'Hufflepuff Squad', 'weeks_played' => 3, 'points' => 1,
        'members' => [
            ['name' => 'Cedric Diggory', 'job' => 'All-Rounder']
        ]
    ]
];

uasort($teams, function($a, $b) { return $b['points'] <=> $a['points']; });

$fixtures = [
    1 => [
        ['match_id' => 101, 'home_id' => 1, 'home_name' => 'Gryffindor United', 'away_id' => 2, 'away_name' => 'Slytherin FC', 's1_h' => 2, 's1_a' => 1, 's2_h' => 3, 's2_a' => 0],
        ['match_id' => 102, 'home_id' => 3, 'home_name' => 'Ravenclaw Elite', 'away_id' => 4, 'away_name' => 'Hufflepuff Squad', 's1_h' => 1, 's1_a' => 2, 's2_h' => 2, 's2_a' => 0]
    ],
    2 => [
        ['match_id' => 201, 'home_id' => 1, 'home_name' => 'Gryffindor United', 'away_id' => 3, 'away_name' => 'Ravenclaw Elite', 's1_h' => 3, 's1_a' => 2, 's2_h' => 1, 's2_a' => 3],
        ['match_id' => 202, 'home_id' => 2, 'home_name' => 'Slytherin FC', 'away_id' => 4, 'away_name' => 'Hufflepuff Squad', 's1_h' => 4, 's1_a' => 1, 's2_h' => 2, 's2_a' => 1]
    ],
    3 => [
        ['match_id' => 301, 'home_id' => 1, 'home_name' => 'Gryffindor United', 'away_id' => 4, 'away_name' => 'Hufflepuff Squad', 's1_h' => 1, 's1_a' => 0, 's2_h' => null, 's2_a' => null],
        ['match_id' => 302, 'home_id' => 2, 'home_name' => 'Slytherin FC', 'away_id' => 3, 'away_name' => 'Ravenclaw Elite', 's1_h' => null, 's1_a' => null, 's2_h' => null, 's2_a' => null]
    ]
];

$last_active_week = 3;
$ordered_weeks = array_keys($fixtures);
if (($key = array_search($last_active_week, $ordered_weeks)) !== false) {
    unset($ordered_weeks[$key]);
    array_unshift($ordered_weeks, $last_active_week);
}

function getFieldWinner($h_score, $a_score, $h_name, $a_name) {
    if ($h_score === null || $a_score === null) {
        return ['text' => '-', 'class' => 'bg-slate-50 text-slate-400 font-bold border border-slate-200/80 text-lg'];
    }
    if ($h_score > $a_score) {
        return ['text' => '🏆 ' . $h_name, 'class' => 'bg-blue-50 text-blue-700 border-2 border-blue-200 text-xs font-bold shadow-sm'];
    }
    return ['text' => '🏆 ' . $a_name, 'class' => 'bg-red-50 text-red-600 border-2 border-red-200 text-xs font-bold shadow-sm'];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏆 League Tournament Tournament</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Sarabun', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen pb-24" x-data="{ activeMatch: null, activeTeam: null }">

    <!-- Premium Header -->
    <header class="bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white py-14 px-8 shadow-xl mb-12 border-b-4 border-red-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-radial-gradient(circle_at_top,_var(--tw-gradient-stops)) from-white/5 via-transparent to-transparent"></div>
        <div class="container mx-auto max-w-7xl flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
            <div>
                <span class="bg-red-600 text-white text-[11px] px-3 py-1 rounded-md font-extrabold uppercase tracking-widest shadow-sm">LEAGUE DASHBOARD</span>
                <h1 class="text-3xl md:text-4xl font-black mt-2 tracking-tight">🏆 TOURNAMENT CHAMPIONS</h1>
                <p class="text-slate-300 text-sm mt-1.5 font-medium">ระบบคำนวณคะแนนแบบเรียลไทม์ • แข่งขันสัปดาห์ละ 2 สนามสะสมแต้ม</p>
            </div>
            <a href="backend.php" class="bg-white hover:bg-slate-100 text-blue-950 px-6 py-3 rounded-xl font-extrabold text-sm transition-all shadow-md hover:shadow-lg border border-slate-200">
                ⚙️ ระบบหลังบ้าน
            </a>
        </div>
    </header>

    <!-- Main Content Grid -->
    <main class="container mx-auto max-w-7xl px-4 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- ================= ฝั่งซ้าย: ตารางคะแนนรวม (5 Columns) ================= -->
        <div class="lg:col-span-4">
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-md sticky top-6">
                <h2 class="text-lg font-black text-blue-950 border-b-2 border-red-600 pb-2.5 mb-5 flex items-center gap-2">
                    📊 ตารางคะแนนสะสม
                </h2>
                <div class="overflow-hidden rounded-xl border border-slate-200 shadow-sm bg-white">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-blue-950 text-white text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 text-left">ทีม</th>
                                <th class="p-4 text-center w-24">สัปดาห์</th>
                                <th class="p-4 text-center w-20 bg-red-600 font-black">แต้ม</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $rank = 1; foreach($teams as $id => $stat): ?>
                                <tr class="hover:bg-slate-50/80 transition cursor-pointer group" @click="activeTeam = (activeTeam === <?= $id ?> ? null : <?= $id ?>)">
                                    <td class="p-4 font-semibold flex items-center gap-2">
                                        <span class="w-5 text-center text-xs font-bold text-slate-400 group-hover:text-blue-600"><?= $rank++ ?></span>
                                        <span class="text-slate-800">🛡️ <?= htmlspecialchars($stat['name']) ?></span>
                                    </td>
                                    <td class="p-4 text-center text-slate-500 font-mono font-medium"><?= $stat['weeks_played'] ?></td>
                                    <td class="p-4 text-center bg-red-50/60 font-black text-red-600 text-base font-mono"><?= $stat['points'] ?></td>
                                </tr>
                                <!-- Dropdown รายชื่อสมาชิกใต้ชื่อทีม -->
                                <tr x-show="activeTeam === <?= $id ?>" x-collapse x-cloak class="bg-slate-50/50">
                                    <td colspan="3" class="p-4 border-t border-slate-200/60 shadow-inner">
                                        <div class="space-y-1.5">
                                            <?php foreach($stat['members'] as $m): ?>
                                                <div class="bg-white p-3 rounded-xl flex justify-between items-center text-xs border border-slate-200 shadow-sm">
                                                    <span class="text-slate-800 font-semibold"><?= htmlspecialchars($m['name']) ?></span>
                                                    <span class="px-2 py-0.5 rounded-md font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase text-[10px]">⚔️ <?= htmlspecialchars($m['job']) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= ฝั่งขวา: ตารางการแข่งขันรายสัปดาห์ (8 Columns) ================= -->
        <div class="lg:col-span-8 space-y-8">
            <h2 class="text-lg font-black text-blue-950 flex items-center gap-2">📅 โปรแกรมและผลการแข่งขัน</h2>
            
            <?php foreach($ordered_weeks as $week): 
                $is_top = ($week == $last_active_week);
                $week_matches = $fixtures[$week];
            ?>
                <div class="bg-white border-2 <?= $is_top ? 'border-red-600 shadow-xl ring-4 ring-red-600/5' : 'border-slate-200 shadow-md' ?> rounded-2xl overflow-hidden transition-all duration-300">
                    
                    <!-- ส่วนหัวการ์ดรายสัปดาห์ -->
                    <div class="<?= $is_top ? 'bg-gradient-to-r from-red-600 to-red-700' : 'bg-gradient-to-r from-blue-950 to-blue-900' ?> px-6 py-4.5 font-bold text-white flex justify-between items-center shadow-md">
                        <div class="flex items-center gap-3">
                            <span class="text-base tracking-wide uppercase font-black">สัปดาห์ที่ <?= $week ?></span>
                            <?php if($is_top): ?>
                                <span class="bg-white text-red-600 text-[10px] px-2.5 py-0.5 rounded-full font-black shadow-sm animate-pulse">LATEST</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs font-mono opacity-70">MATCHWEEK 0<?= $week ?></span>
                    </div>
                    
                    <!-- รายการคู่แข่งขัน (ปรับความกว้าง ความยาว ให้หรูหราขึ้น) -->
                    <div class="p-5 space-y-5 bg-slate-50/30">
                        <?php foreach($week_matches as $m): 
                            $win1 = getFieldWinner($m['s1_h'], $m['s1_a'], $m['home_name'], $m['away_name']);
                            $win2 = getFieldWinner($m['s2_h'], $m['s2_a'], $m['home_name'], $m['away_name']);
                        ?>
                            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden flex flex-col transition-all duration-200 hover:shadow-md hover:border-slate-300">
                                
                                <!-- แถวหลักแสดงแมตช์คู่แข่งขันและริบบิ้นผู้ชนะแบบโปร่งโล่งขึ้น -->
                                <div class="p-8 pb-5 flex flex-col lg:flex-row justify-between items-center gap-6">
                                    
                                    <!-- ฝั่งทีมคู่แข่ง -->
                                    <div class="flex items-center justify-center gap-4 flex-1 w-full lg:w-7/12">
                                        <div class="w-5/12 text-right font-black text-blue-950 text-base tracking-wide truncate">
                                            <?= htmlspecialchars($m['home_name']) ?>
                                        </div>
                                        <span class="bg-slate-100 text-slate-400 border border-slate-200 text-[10px] px-3 py-1 rounded-lg font-black font-mono shadow-inner select-none">VS</span>
                                        <div class="w-5/12 text-left font-black text-blue-950 text-base tracking-wide truncate">
                                            <?= htmlspecialchars($m['away_name']) ?>
                                        </div>
                                    </div>
                                    
                                    <!-- ฝั่งริบบิ้นสรุปผลผู้ชนะ -->
                                    <div class="w-full lg:w-5/12 flex gap-3.5 justify-center lg:justify-end">
                                        <!-- สนามที่ 1 -->
                                        <div class="px-4 py-3 rounded-xl flex flex-col items-center min-w-[140px] justify-center shadow-sm <?= $win1['class'] ?>">
                                            <span class="text-[9px] uppercase tracking-wider font-extrabold mb-1 opacity-70">สนาม 1 ผู้ชนะ</span>
                                            <span class="tracking-wide text-center truncate max-w-[130px] font-bold"><?= $win1['text'] ?></span>
                                        </div>
                                        <!-- สนามที่ 2 -->
                                        <div class="px-4 py-3 rounded-xl flex flex-col items-center min-w-[140px] justify-center shadow-sm <?= $win2['class'] ?>">
                                            <span class="text-[9px] uppercase tracking-wider font-extrabold mb-1 opacity-70">สนาม 2 ผู้ชนะ</span>
                                            <span class="tracking-wide text-center truncate max-w-[130px] font-bold"><?= $win2['text'] ?></span>
                                        </div>
                                    </div>

                                </div>

                                <!-- 🧭 ปุ่มกดขยายดีไซน์พรีเมียมอยู่กึ่งกลางบรรทัดด้านล่างสุด -->
                                <div @click="activeMatch = (activeMatch === <?= $m['match_id'] ?> ? null : <?= $m['match_id'] ?>)"
                                     class="bg-slate-50/70 hover:bg-slate-100/90 py-3 flex items-center justify-center cursor-pointer border-t border-slate-100 transition-all group select-none">
                                    <div class="text-xs text-slate-500 group-hover:text-red-600 font-bold tracking-wide flex items-center gap-2">
                                        <span>ดูรายชื่อสมาชิกและอาชีพตัวละคร</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform duration-300 text-slate-400 group-hover:text-red-600"
                                             :class="activeMatch === <?= $m['match_id'] ?> ? 'rotate-180 text-red-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- บล็อกสไลด์แสดงสมาชิกแยกเป็น 2 ฝั่งเมื่อกดเปิด -->
                                <div x-show="activeMatch === <?= $m['match_id'] ?>" x-collapse x-cloak class="bg-slate-50/40 border-t border-slate-200/80 p-6 shadow-inner">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        
                                        <!-- สมาชิกทีมเหย้า -->
                                        <div class="space-y-2.5">
                                            <div class="text-xs font-black text-blue-900 border-b border-slate-200 pb-2 flex items-center gap-1.5 uppercase tracking-wider">
                                                🛡️ TEAM [<?= htmlspecialchars($m['home_name']) ?>]
                                            </div>
                                            <div class="space-y-1.5">
                                                <?php foreach($teams[$m['home_id']]['members'] as $mem): ?>
                                                    <div class="flex justify-between items-center bg-white border border-slate-200/80 p-3.5 rounded-xl shadow-sm hover:border-slate-300 transition">
                                                        <span class="text-slate-800 font-bold text-sm"><?= htmlspecialchars($mem['name']) ?></span>
                                                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-wide">⚔️ <?= htmlspecialchars($mem['job']) ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- สมาชิกทีมเยือน -->
                                        <div class="space-y-2.5">
                                            <div class="text-xs font-black text-red-600 border-b border-slate-200 pb-2 flex items-center gap-1.5 uppercase tracking-wider">
                                                🛡️ TEAM [<?= htmlspecialchars($m['away_name']) ?>]
                                            </div>
                                            <div class="space-y-1.5">
                                                <?php foreach($teams[$m['away_id']]['members'] as $mem): ?>
                                                    <div class="flex justify-between items-center bg-white border border-slate-200/80 p-3.5 rounded-xl shadow-sm hover:border-slate-300 transition">
                                                        <span class="text-slate-800 font-bold text-sm"><?= htmlspecialchars($mem['name']) ?></span>
                                                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-wide">⚔️ <?= htmlspecialchars($mem['job']) ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>