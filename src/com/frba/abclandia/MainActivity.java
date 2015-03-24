package com.frba.abclandia;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;


public class MainActivity extends Activity {
	private static final String PREFERENCE_NAME = "com.frba.abclandia";
	private static final int DISPLAY = 3000;
	SharedPreferences preferences = null;
	String TARGET_BASE_PATH;
	
	protected void callNextActivity(){
		startActivity(new Intent(this, ActividadesActivity.class));
	}
	
	protected void onCreate(Bundle paramBundle){
		super.onCreate(paramBundle);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, 
		WindowManager.LayoutParams.FLAG_FULLSCREEN);
		setContentView(R.layout.activity_splash);
		
		
		setPreferences();
		
		
		new Handler().postDelayed(new Runnable() {
			
			@Override
			public void run() {
				MainActivity.this.callNextActivity();
				MainActivity.this.finish();
				
			}
		}, DISPLAY);
		

	}

	protected void setPreferences() {
		preferences = getSharedPreferences(PREFERENCE_NAME, MODE_PRIVATE);
		SharedPreferences.Editor editor = preferences.edit();
		editor.putInt("letter_type", 1);
		editor.commit();
	}
	

	

	@Override
    protected void onResume() {
        super.onResume();
        
        TARGET_BASE_PATH =  getFilesDir() + "/";

        if (preferences.getBoolean("firstrun", true)) {
            
        	preferences.edit().putBoolean("firstrun", false).commit();
//        	copyFileOrDir("sonidos");
//            copyFileOrDir("imagenes");

             Log.d("ABCLandia", "Primer Ejecucion");   
        }
    }
	
	
	@Override
	protected void onDestroy() {
	    super.onDestroy();
	    
	}
	
	


	

}


