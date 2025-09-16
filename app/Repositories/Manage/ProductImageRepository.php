<?php

namespace App\Repositories\Manage;

use App\Models\Products;
use App\Models\ProductsImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ProductImageRepository
{
    public function index($productID, $orderBy = null)
    {
        try {
            $productImageDB = ProductsImages::query()->with(['product']);

            if($productID) {
                $productImageDB->where('product_id', $productID);
            }

            if($orderBy) {
                $productImageDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            $productImageDB = $productImageDB->get();

            return [
                'status' => 'success',
                'data' => $productImageDB,
                'code' => 200
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }
    public function create($product_id, $images = null)
    {
        try {
            DB::beginTransaction();

            if($images != null){
                foreach ($images as $image) {
                    $image = $image->store('products_images', 'public');

                    $productImageDB = ProductsImages::query()->create([
                        'product_id' => $product_id,
                        'path' => $image
                    ]);
                }
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productImageDB,
                'code' => 200,
                'message' => 'Imagens cadastradas com sucesso !'
            ];

        } catch (Exception $exception){
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }

    public function delete($id = null)
    {
        try {
            DB::beginTransaction();

            $productImagesDB = ProductsImages::query()->findOrFail($id);

            if(Storage::exists('public/'.$productImagesDB->path)) {
                Storage::delete('public/'.$productImagesDB->path);
            }

            $productImagesDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $productImagesDB,
                'code' => 200,
                'message' => 'Produto deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

}
