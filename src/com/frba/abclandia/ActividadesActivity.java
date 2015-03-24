package com.frba.abclandia;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;

import com.example.abclandia.AbcPlayerActivity;
import com.example.abclandia.CardLetterPlayerActivity;

public class ActividadesActivity extends Activity {
	
	private int unMaestro = 0;
	private int unAlumno = 0;
	private int unaCategoria = 0;
	
	protected void onCreate(Bundle paramBundle){
		super.onCreate(paramBundle);
		
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, 
		WindowManager.LayoutParams.FLAG_FULLSCREEN);
		
		setContentView(R.layout.actividades_activity);
	
		Intent i = getIntent();
		this.unMaestro = i.getIntExtra("unMaestro", 0);
		this.unAlumno = i.getIntExtra("unAlumno", 0);
		
	}
	
	
	public void btnReproducirAbecedario(View view){
		
		Intent intent = new Intent(this,AbcPlayerActivity.class );
		intent.putExtra("unMaestro", unMaestro);
		intent.putExtra("unAlumno", unAlumno);
		intent.putExtra("unaCategoria", unaCategoria);
		startActivity(intent);
	}
	
	public void btnReproducirLetra(View view){
		
		Intent intent = new Intent(this,CardLetterPlayerActivity.class );
		intent.putExtra("unMaestro", unMaestro);
		intent.putExtra("unAlumno", unAlumno);
		intent.putExtra("unaCategoria", unaCategoria);
		startActivity(intent);
	}
	
	public void btnJugar(View view){
		//TODO: Llamar a JugarActivity
    	Intent intent = new Intent(this, JugarActivity.class);
		intent.putExtra("unMaestro", unMaestro);
		intent.putExtra("unAlumno", unAlumno);
		intent.putExtra("unaCategoria", unaCategoria);
		startActivity(intent);
	}
}
