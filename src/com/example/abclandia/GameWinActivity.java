package com.example.abclandia;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;

import com.frba.abclandia.ActividadesActivity;
import com.frba.abclandia.R;

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

		Button btnBackToMenu = (Button) findViewById(R.id.btnBackToMenu);
		Button btnPlayAgain = (Button) findViewById(R.id.btnPlayAgain);
		
		getExtraData();
		btnBackToMenu.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				
				Intent intent = new Intent(GameWinActivity.this, ActividadesActivity.class);
				
				startActivity(intent);
				finish();
				

			}
		});
		btnPlayAgain.setOnClickListener(new OnClickListener() {

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
