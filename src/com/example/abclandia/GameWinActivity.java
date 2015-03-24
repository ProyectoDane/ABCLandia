package com.example.abclandia;

import com.frba.abclandia.ActividadesActivity;
import com.frba.abclandia.R;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.widget.ImageButton;

public class GameWinActivity extends Activity {
	
	private Class<?> classLauncher;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		WindowManager mWindowManager = (WindowManager) getSystemService("window");
		
		setContentView(R.layout.game_win_activity);

		ImageButton btnMenu = (ImageButton) findViewById(R.id.btnMenu);
		ImageButton btnVolverAJugar = (ImageButton) findViewById(R.id.btnVolverAJugar);
		
		getExtraData();
		btnMenu.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				
				Intent intent = new Intent(GameWinActivity.this, ActividadesActivity.class);
				
				startActivity(intent);
				finish();
				

			}
		});
		btnVolverAJugar.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				
				
				Intent intent = new Intent(GameWinActivity.this, classLauncher);
				intent.putExtra(GameActivity.INTENT_LEVEL_KEY, 1);
				intent.putExtra(GameActivity.INTENT_SECUENCE_KEY, 1);
				
				startActivity(intent);
				finish();
				

			}
		});
	}
	
	
	protected void getExtraData() {
		Bundle extras = getIntent().getExtras();
	
		if (extras != null) {
			

			try {
				classLauncher = Class.forName(extras
						.getString(GameActivity.INTENT_CLASS_LAUNCHER_KEY));
			} catch (ClassNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}

		}

	}
	


}
