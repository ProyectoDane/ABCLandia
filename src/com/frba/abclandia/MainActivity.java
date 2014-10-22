package com.frba.abclandia;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import org.json.JSONException;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.AssetManager;
import android.database.SQLException;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;

import com.frba.abclandia.db.DataBaseHelper;
import com.frba.abclandia.webserver.ABCLandiaRestServer;


public class MainActivity extends Activity {
	
	private static final int DISPLAY = 3000;
	private DataBaseHelper myDbHelper;
	SharedPreferences prefs = null;
	String TARGET_BASE_PATH;
	
	protected void callNextActivity(){
		startActivity(new Intent(this, LoginActivity.class));
	}
	
	protected void onCreate(Bundle paramBundle){
		super.onCreate(paramBundle);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, 
		WindowManager.LayoutParams.FLAG_FULLSCREEN);
		setContentView(R.layout.activity_splash);
		
		//Iniciamos la base de datos
		iniciarDB();

		prefs = getSharedPreferences("com.frba.abclandia", MODE_PRIVATE);
		
		new Handler().postDelayed(new Runnable() {
			
			@Override
			public void run() {
				MainActivity.this.callNextActivity();
				MainActivity.this.finish();
				
			}
		}, DISPLAY);
		

	}
	
	/**
	 * Iniciamos la base de datos
	 * Esto pasa porque no creamos un Singleton
	 */
	private void iniciarDB() {
		// Inicializar servicios
		myDbHelper = new DataBaseHelper(this);
		try {
			myDbHelper.createDatabase();
		} catch (IOException ioe) {
			throw new Error("No se pudo crear la base de datos");		
		}
		
		try {
			myDbHelper.openDatabase();
		}catch (SQLException sqle){
			Log.d("ABCLandia", "No se pudo abrir la BD");
			throw sqle;
		}
	}
	

	@Override
    protected void onResume() {
        super.onResume();
        TARGET_BASE_PATH = getExternalFilesDir(null).toString() + "/";
        String c = Environment.getExternalStorageDirectory().toString();
        
        /*
         * Copiamos las imagenes y sonidos a la carpeta por defecto
         * Esto deberia quitarse en un futuro.
         */
        
        copyFileOrDir("default_sounds");
        copyFileOrDir("default_images");

        if (prefs.getBoolean("firstrun", true)) {
            // Do first run stuff here then set 'firstrun' as false
            // using the following line to edit/commit prefs
        	prefs.edit().putBoolean("firstrun", false).commit();
             	
        	Log.d("ABCLandia", "Primer Ejecucion");   
        }
    }
	

	@Override
	protected void onDestroy() {
	    super.onDestroy();
	    if (myDbHelper != null) {
	    	myDbHelper.close();
	    }
	}
	
	private void copyFileOrDir(String path) {
	    AssetManager assetManager = this.getAssets();
	    String assets[] = null;
	    try {
	        Log.i("tag", "copyFileOrDir() "+path);
	        assets = assetManager.list(path);
	        if (assets.length == 0) {
	            copyFile(path);
	        } else {
	            String fullPath =  TARGET_BASE_PATH + path;
	            Log.i("tag", "path="+fullPath);
	            File dir = new File(fullPath);
	            if (!dir.exists() )
	                if (!dir.mkdirs())
	                    Log.i("tag", "could not create dir "+fullPath);
	            for (int i = 0; i < assets.length; ++i) {
	                String p;
	                if (path.equals(""))
	                    p = "";
	                else 
	                    p = path + "/";

	               
	                    copyFileOrDir( p + assets[i]);
	            }
	        }
	    } catch (IOException ex) {
	        Log.e("tag", "I/O Exception", ex);
	    }
	}

	private void copyFile(String filename) {
	    AssetManager assetManager = this.getAssets();

	    InputStream in = null;
	    OutputStream out = null;
	    String newFileName = null;
	    try {
	        Log.i("tag", "copyFile() "+filename);
	        in = assetManager.open(filename);
	        
	            newFileName = TARGET_BASE_PATH + filename;
	        out = new FileOutputStream(newFileName);

	        byte[] buffer = new byte[1024];
	        int read;
	        while ((read = in.read(buffer)) != -1) {
	            out.write(buffer, 0, read);
	        }
	        in.close();
	        in = null;
	        out.flush();
	        out.close();
	        out = null;
	    } catch (Exception e) {
	        Log.e("tag", "Exception in copyFile() of "+newFileName);
	        Log.e("tag", "Exception in copyFilee() "+e.toString());
	    }
	}
}

