<?php
namespace App\Http\Controllers;
use App\Models\HeaderTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $invitation = auth()->user()->invitation;
        $category = request('category');
        $query = HeaderTemplate::where('aktif', true);
        if ($category) {
            $query->where('category', $category);
        }
        $templates = $query->orderBy('urutan')->get();
        
        if (!$invitation) {
            return view('dashboard.index', ['invitation' => null, 'templates' => $templates]);
        }
        $rsvpCount = $invitation->rsvpResponses()->count();
        $wishCount = $invitation->wishes()->count();
        return view('dashboard.index', compact('invitation', 'rsvpCount', 'wishCount', 'templates'));
    }

    public function update(Request $request)
    {
        $invitation = auth()->user()->invitation;
        $data = $request->except(['_token', '_method', 'qr_image', 'aturcara']);

        if ($request->filled('header_image')) {
            $data['header_image'] = ltrim(str_replace('/storage/', '', $request->header_image), '/');
        }

        if ($request->hasFile('qr_image')) {
            if ($invitation->qr_image) Storage::disk('public')->delete($invitation->qr_image);
            $data['qr_image'] = $request->file('qr_image')->store('qr', 'public');
        }

        if ($request->has('aturcara')) {
            $raw = $request->input('aturcara');
            if (is_string($raw) && $raw !== '') {
                $decoded = json_decode($raw, true);
                $data['aturcara'] = is_array($decoded) ? $decoded : [];
            } else {
                $data['aturcara'] = [];
            }
        }

        // Handle Boolean Toggles
        $boolFields = [
            'pranikah_aktif', 'rsvp_aktif', 'hadiah_aktif', 
            'gallery_aktif', 'aturcara_aktif', 'animation_aktif'
        ];
        foreach ($boolFields as $field) {
            $data[$field] = $request->has($field);
        }

        if ($request->has('animation_type')) {
            $data['animation_type'] = $request->animation_type;
        }

        $data['muzik_aktif'] = !empty($data['muzik_youtube_url']) ? 1 : 0;
        $invitation->update($data);
        return back()->with('success', 'Tetapan berjaya disimpan!');
    }

    public function uploadGallery(Request $request)
    {
        $request->validate([
            'images.*' => 'image|max:15360', // 15MB
            'jenis' => 'in:gallery,pranikah',
        ]);

        $invitation = auth()->user()->invitation;
        $jenis = $request->jenis ?? 'gallery';
        
        // Count existing images
        $existingCount = $invitation->galleries()->where('jenis', $jenis)->count();
        $newCount = count($request->file('images'));

        if ($existingCount + $newCount > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya boleh memuat naik maksimum 5 gambar untuk bahagian ini.'
            ], 422);
        }

        $urutan = $existingCount;
        $uploaded = [];

        foreach ($request->file('images') as $file) {
            // Processing path
            $tempPath = $file->getRealPath();
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '.jpg'; // Convert all to jpg for better compression
            $savePath = 'gallery/' . $filename;

            // Load Image
            list($width, $height, $type) = getimagesize($tempPath);
            switch ($type) {
                case IMAGETYPE_JPEG: $source = imagecreatefromjpeg($tempPath); break;
                case IMAGETYPE_PNG:  $source = imagecreatefrompng($tempPath); break;
                case IMAGETYPE_GIF:  $source = imagecreatefromgif($tempPath); break;
                case IMAGETYPE_WEBP: $source = imagecreatefromwebp($tempPath); break;
                default: continue 2;
            }

            // Resize if necessary (max width 1200px)
            $maxWidth = 1200;
            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor(($height / $width) * $newWidth);
                $target = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($target, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($source);
                $source = $target;
            }

            // Save compressed to string buffer then to Storage
            ob_start();
            imagejpeg($source, null, 75); // 75% quality
            $compressedData = ob_get_clean();
            imagedestroy($source);

            // Store in disk
            Storage::disk('public')->put($savePath, $compressedData);

            $img = $invitation->galleries()->create([
                'image_path' => $savePath,
                'jenis' => $jenis,
                'urutan' => $urutan++,
            ]);

            $uploaded[] = [
                'id' => $img->id,
                'url' => Storage::url($savePath),
            ];
        }

        return response()->json(['success' => true, 'images' => $uploaded]);
    }

    public function deleteGallery(\App\Models\Gallery $gallery)
    {
        if ($gallery->invitation->user_id !== auth()->id()) abort(403);
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return response()->json(['success' => true]);
    }

    public function deleteQR(Request $request)
    {
        $invitation = auth()->user()->invitation;

        if (!$invitation || !$invitation->qr_image) {
            return response()->json([
                'success' => false,
                'message' => 'Tiada QR untuk dipadam.'
            ], 404);
        }

        if (Storage::disk('public')->exists($invitation->qr_image)) {
            Storage::disk('public')->delete($invitation->qr_image);
        }

        $invitation->update(['qr_image' => null]);

        return response()->json(['success' => true]);
    }

    public function rsvpList()
    {
        $invitation = auth()->user()->invitation;
        $rsvps = $invitation->rsvpResponses()->latest()->get();
        return view('dashboard.rsvp', compact('invitation', 'rsvps'));
    }

    public function wishesList()
    {
        $invitation = auth()->user()->invitation;
        $wishes = $invitation->wishes()->latest()->get();
        return view('dashboard.wishes', compact('invitation', 'wishes'));
    }
}