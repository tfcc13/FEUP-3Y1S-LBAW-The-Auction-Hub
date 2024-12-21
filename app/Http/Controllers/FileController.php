<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\User;
use App\Models\UserImage;
use App\Models\AuctionImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    static $default = 'default.jpg';
    static $diskName = 'Auctions';

    static $systemTypes = [
        'auction' => ['png', 'jpg', 'jpeg', 'gif'],
        'user' => ['png', 'jpg', 'jpeg', 'gif'],
    ];


    private static function getDefaultExtension(String $type) {
        return reset(self::$systemTypes[$type]);
    }

    private static function isValidExtension(String $type, String $extension) {
        $allowedExtensions = self::$systemTypes[$type];

        // Note the toLowerCase() method, it is important to allow .JPG and .jpg extensions as well
        return in_array(strtolower($extension), $allowedExtensions);
    }

    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(String $type) {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName(String $type, int $id, String $extension = null) {

        $fileName = null;
        
        switch($type) {
            case 'auction':
                //$auctionImage = AuctionImage::where('auction_id', $id)->first();
                //$fileName = $auctionImage->path;
                $fileName = Auction::find($id)->primaryImage();
                break;
            case'user':
                $userImage = User::find($id)->userImage;
                $fileName = $userImage ? $userImage->path :null;
                break;
                
            default:
                return null;
        }

        return $fileName;
    }

    private static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);
            switch($type) {
                case 'user':
                    User::findOrFail($id)->userImage = null;
                    break;
            }
        }
    }
    function uploadUserImage(Request $request, $id) {
        
        $validated = $request->validate([
            'type' => 'required|string',
            'file' => 'required|image|mimes:png,jpg,jpeg,gif|max:10240',
        ]);
        
        
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Error: File not found');
        }
        
        // Validation: upload type
        if (!$this->isValidType($request->type)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload type');
        }
        
        $file = $request->file('file');

        $type = $request->type;
        
        $extension = $file->extension();
                if (!$this->isValidExtension($type, $extension)) {
                    return redirect()->back()->with('error', 'Error: Unsupported upload extension');
                }
        $fileName = $file->hashName();
        $user = User::findOrFail($id);
                    if($user){
                        if($user->userImage()->exists()) {
                            $this->delete($type, $id);
                            $user->userImage()->update(['path' => $fileName]);
                        } else {
                            $user->userImage()->create(['path' => $fileName]);
                        }                    
                    }
                    else {
                        redirect()->back()->with('error', "Error: Inexistent user");
                    }
        
        $path = "user";
        $file->storeAs($path, $fileName, self::$diskName);
        
        return redirect()->back()->with('success', 'Success: upload completed!');
    }

    function uploadAuctionImages(Request $request, $id) {
        
        $validated = $request->validate([
            'type' => 'required|string',
            'files.*' => 'required|image|mimes:png,jpg,jpeg,gif|max:10240',
        ]);

        
 
   /*      if ($request->hasFile('files')) {
            dd($request->file('files')); // This should be an array of uploaded files
        } */
        // Validation: has file
        if (!$request->hasFile('files')) {
            return redirect()->back()->with('error', 'Error: File not found');
        }
        

        // Validation: upload type
        if (!$this->isValidType($request->type)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload type');
        }

        // Validation: upload extension
        $type = $request->type;
        

        // Prevent existing old files
        //$this->delete($type, $id);

        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $extension = $file->extension();
                if (!$this->isValidExtension($type, $extension)) {
                    return redirect()->back()->with('error', 'Error: Unsupported upload extension');
                }
                // Get the original filename
                // Generate unique filename
                $fileName = $file->hashName();
                
                $auction = Auction::findOrFail($id);
                if ($auction) {
                    //$auction->profile_image = $fileName;
                    $auctionImage = new AuctionImage([
                        'path'  => $fileName,
                        'auction_id' => $id,
                    ]);
                    $auctionImage->save();
                } else {
                    redirect()->back()->with('error', 'Error: Unsupported upload object');
                }
                $path = "auction/{$auction->id}";
                
                $file->storeAs($path, $fileName, self::$diskName);
                
            }
        }    
        
        return redirect()->back()->with('success', 'Success: upload completed!');
    }
    
/* 
    static function getAuctionImage(String $type, int $auction_id) {

        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        $path = "images/auction/{$auction_id}";
        // Retrieve the file name from the auction model (if stored in the database)
        $fileName = self::getFileName($type, $auction_id);
        
        if ($fileName) {
            $filePath = "images/auction/{$auction_id}/{$fileName}";
            return asset($filePath); // Return full URL to the file
        }
    
        // Not found: returns default asset
        return self::defaultAsset($type);
    } */

    
    static function getAuctionImages(int $auction_id) {
        $path = "images/auction/{auction_id}";

        $files = Storage::files($path);
        
        $imageFiles = array_filter($files, function ($file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
        });
        
        dd($imageFiles);

        return $imageFiles;
    }
    
    
    static function getAuctionImage( $type, $auction_id, $fileName) {
        
        $path = "images/auction/{$auction_id}";

        
        if ($fileName) {
            $filePath = "images/auction/{$auction_id}/{$fileName}";
            return asset($filePath); // Return full URL to the file
        }
    
        // Not found: returns default asset
        return self::defaultAsset($type);
    }

}
