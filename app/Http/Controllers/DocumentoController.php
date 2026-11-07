<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DocumentoLegal;

class DocumentoController extends Controller {
    public function index() {
        $documentos = DocumentoLegal::all();
        return view('documentos.index', compact('documentos'));
    }
    public function create() {
        return view('documentos.create');
    }
    public function store(Request $request) {
        $request->validate(['tipo_documento' => 'required', 'fecha_emision' => 'required|date', 'fecha_caducidad' => 'required|date']);
        DocumentoLegal::create($request->all());
        return redirect()->route('documentos.index')->with('success', 'Documento registrado.');
    }
    public function destroy($id) {
        DocumentoLegal::findOrFail($id)->delete();
        return redirect()->route('documentos.index')->with('success', 'Documento eliminado.');
    }
}