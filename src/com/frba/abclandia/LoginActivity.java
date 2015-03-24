package com.frba.abclandia;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;

public class LoginActivity extends Activity {
	private static String PREFERENCE_NAME = "com.frba.abclandia";
	enum Answer { YES, NO, ERROR, NULL};
	Answer respuesta = Answer.NULL;
	
	SharedPreferences preferences;
	public boolean showMessageMaestro, showMessagePadre;
	
	
	protected void onCreate(Bundle paramBundle){
		super.onCreate(paramBundle);
		
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, 
		WindowManager.LayoutParams.FLAG_FULLSCREEN);
		setContentView(R.layout.login_activity);
		
		preferences = getSharedPreferences(PREFERENCE_NAME, MODE_PRIVATE);
		SharedPreferences.Editor editor = preferences.edit();
		editor.putInt("letter_type", 1);
		editor.commit();
		
		showMessageMaestro = preferences.getBoolean("showMessageMaestro", true);
		showMessagePadre = preferences.getBoolean("showMessagePadre", true);
            // Do first run stuff here then set 'firstrun' as false
            // using the following line to edit/commit prefs

        	
		}
	
	public void loginMaestro(View view){
		if (showMessageMaestro)
			showMsgDialogMaestro(this);
		else{
//			Intent intent = new Intent(this, MaestrosActivity.class);
//    		startActivity(intent);
		}
	}
	
	public void loginPadre (View view){
		if (showMessagePadre)
			showMsgDialogPadre(this);	
		else{
			Intent intent = new Intent(this, ActividadesActivity.class);
			startActivity(intent);
			
		}
			
	}
	
	public void loginPadreOk(){
		if (respuesta == Answer.YES){
			//TODO: Llamamos los niveles.
			
		}
	}
	
	public void showMsgDialogPadre(final Context self) {
		
		AlertDialog.Builder dlgMensaje = new AlertDialog.Builder(this);
		dlgMensaje.setMessage(R.string.msgPadre);
		dlgMensaje.setTitle(R.string.app_name);
		View checkBoxView = View.inflate(this, R.layout.checkbox, null);
		CheckBox checkBox = (CheckBox) checkBoxView.findViewById(R.id.chxSkip);
		checkBox.setOnCheckedChangeListener(new OnCheckedChangeListener() {

		    @Override
		    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
		    	if (isChecked)
		    		showMessagePadre = false;
		    		preferences.edit().putBoolean("showMessagePadre", false).commit();

		        
		    }
		});
		dlgMensaje.setView(checkBoxView);
		dlgMensaje.setPositiveButton(R.string.msgAceptar,  new DialogInterface.OnClickListener() {
	        public void onClick(DialogInterface dialog, int which) {
	    		//TODO: Usuario acepta el mensaje
	        	
	        	respuesta = Answer.YES;
	        	Intent intent = new Intent(self, ActividadesActivity.class);
	    		//TODO Pasamos datos si hay que pasarlos.
	    		startActivity(intent);
	          }
	      });
		dlgMensaje.setCancelable(true);
		dlgMensaje.create().show();
		
	}
	
	public void showMsgDialogMaestro(final Context self) {
		
		AlertDialog.Builder dlgMensaje = new AlertDialog.Builder(this);
		View checkBoxView = View.inflate(this, R.layout.checkbox, null);
		CheckBox checkBox = (CheckBox) checkBoxView.findViewById(R.id.chxSkip);
		checkBox.setOnCheckedChangeListener(new OnCheckedChangeListener() {

		    @Override
		    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

		    	if (isChecked)
		    		showMessageMaestro = false;
		    		preferences.edit().putBoolean("showMessageMaestro", false).commit();

		    }
		});
		dlgMensaje.setView(checkBoxView);
		dlgMensaje.setMessage(R.string.msgMaestro);
		dlgMensaje.setTitle(R.string.app_name);
		dlgMensaje.setPositiveButton(R.string.msgAceptar,  new DialogInterface.OnClickListener() {
	        public void onClick(DialogInterface dialog, int which) {
	        	respuesta = Answer.YES;
//	        	Intent intent = new Intent(self, MaestrosActivity.class);
//	    		startActivity(intent);
	          }
	      });
		dlgMensaje.setCancelable(true);
		dlgMensaje.create().show();
		
	}
	

}
